<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        $styles = Style::orderBy('name')->get();
        $query = Product::query();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('style_id')) {
            $query->where('style_id', $request->style_id);
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $perPage = (int) $request->input('per_page', 10);
        $products = $query->with(['category', 'style'])->orderBy('order', 'asc')->paginate($perPage)->appends($request->all());

        return view('admin.pages.products.list-product', compact('products', 'categories', 'styles'));
    }

    public function addProduct()
    {
        $categories = Category::orderBy('order', 'asc')->get();
        $styles = Style::orderBy('name', 'asc')->get();

        return view(
            'admin.pages.products.add-product',
            compact(
                'categories',
                'styles'
            )
        );
    }

    public function storeProduct(Request $request)
    {
        // 1. Validation không thay đổi
        $validatedData = $request->validate([
            'product_code' => 'required|string|max:191|unique:products,product_code',
            'title' => 'required|string|max:255|unique:products,title',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer|exists:categories,id',
            'style_id' => 'nullable|integer|exists:styles,id',
            'description' => 'nullable|string',
            'tag' => 'nullable|string|max:255',
            'order' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'stock_status' => 'required|string|in:instock,outstock,onbackorder',
            'is_on_top' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'is_sale' => 'nullable|boolean',
            'detail_description' => 'nullable|string',
            'detail_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // 2. Chuẩn bị dữ liệu sản phẩm không thay đổi
            $productData = $request->except(['_token', 'detail_description', 'detail_images']);
            $productData['is_on_top'] = $request->has('is_on_top');
            $productData['is_new'] = $request->has('is_new');
            $productData['is_sale'] = $request->has('is_sale');
            $productData['purchases'] = 0;

            // 3. Xử lý ảnh đại diện không thay đổi
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products_upload', 'public');
                $productData['image'] = 'storage/' . $path;
            }

            // 4. Tạo sản phẩm không thay đổi
            $product = Product::create($productData);

            // =======================================================
            // BẮT ĐẦU PHẦN SỬA LỖI LOGIC
            // =======================================================

            // 5. Tạo chi tiết sản phẩm và lưu ảnh chi tiết vào đó
            $productDetail = null;
            // Chỉ tạo ProductDetail khi có mô tả chi tiết hoặc có ảnh gallery
            if ($request->filled('detail_description') || $request->hasFile('detail_images')) {

                // Tạo product_detail trước
                $productDetail = $product->details()->create([
                    'description' => $request->input('detail_description')
                ]);

                // 6. Xử lý và lưu thư viện ảnh vào product_detail vừa tạo
                if ($request->hasFile('detail_images')) {
                    foreach ($request->file('detail_images') as $key => $file) {
                        $path = $file->store('product_detail_gallery', 'public');

                        // Dùng $productDetail để tạo ảnh, không phải $product
                        // Điều này sẽ tự động gán đúng 'product_detail_id'
                        $productDetail->images()->create([
                            'image' => 'storage/' . $path,
                            'caption' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                            'order' => $key + 1,
                        ]);
                    }
                }
            }

            // =======================================================
            // KẾT THÚC PHẦN SỬA LỖI LOGIC
            // =======================================================

            DB::commit();
            return redirect()->route('admin.product')->with('success', 'Tạo sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi tạo sản phẩm: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }
    public function editProduct($productId)
    {
        $product = Product::with(['category', 'style', 'details', 'detailImages'])->findOrFail($productId);
        $categories = Category::all();
        $styles = Style::all();

        return view('admin.pages.products.edit-product', compact(
            'product',
            'categories',
            'styles'
        ));
    }

    public function updateProduct(Request $request, $productId)
    {
        // LOGGING: Bắt đầu hàm và ghi lại toàn bộ request
        Log::info("==================================================");
        Log::info("Bắt đầu updateProduct cho productId: {$productId}");
        Log::info("Dữ liệu Request đầu vào:", $request->all());

        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255|unique:products,title,' . $product->id,
            'price' => 'sometimes|numeric|min:0',
            'category_id' => 'sometimes|integer|exists:categories,id',
            'style_id' => 'nullable|integer|exists:styles,id',
            'description' => 'nullable|string',
            'tag' => 'nullable|string|max:255',
            'order' => 'sometimes|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_on_top' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'is_sale' => 'nullable|boolean',
        ], [
            'title.required' => 'Tên sản phẩm không được bỏ trống.',
            'price.required' => 'Giá sản phẩm không được bỏ trống.',
            'category_id.required' => 'Bạn phải chọn danh mục sản phẩm.',
        ]);

        // LOGGING: Xem dữ liệu sau khi đã qua validation
        Log::info('Dữ liệu đã qua validation:', $validated);

        DB::beginTransaction();
        try {
            $product->update($validated);

            $product->is_on_top = $request->has('is_on_top');
            $product->is_new = $request->has('is_new');
            $product->is_sale = $request->has('is_sale');

            if ($request->hasFile('image')) {
                Log::info('Phát hiện có file ảnh mới.');
                if ($product->image) {
                    $oldImagePath = Str::replaceFirst('storage/', '', $product->image);
                    Storage::disk('public')->delete($oldImagePath);
                    Log::info('Đã xóa ảnh cũ: ' . $oldImagePath);
                }
                $path = $request->file('image')->store('products_upload', 'public');
                $product->image = 'storage/' . $path;
                Log::info('Đã lưu ảnh mới tại: ' . $product->image);
            }

            // LOGGING: Kiểm tra xem Eloquent có nhận diện được thay đổi nào không TRƯỚC KHI SAVE
            Log::info('Các thuộc tính đã thay đổi (isDirty):', $product->getDirty());

            $product->save(); // Lưu tất cả thay đổi

            // LOGGING: Kiểm tra xem Eloquent đã thực sự lưu thay đổi chưa SAU KHI SAVE
            Log::info('Các thay đổi đã được lưu (getChanges):', $product->getChanges());
            if (!$product->wasChanged()) {
                Log::warning('Eloquent không phát hiện thấy thay đổi nào được lưu vào database.');
            }

            DB::commit();
            Log::info("Đã commit transaction thành công cho productId: {$productId}");
            return redirect()->route('admin.product')->with('success', 'Đã cập nhật sản phẩm!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi cập nhật sản phẩm: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi sửa sản phẩm. Vui lòng thử lại!')->withInput();
        }
    }
    public function deleteProduct($productId)
    {
        try {
            $product = Product::with(['details', 'detailImages'])->findOrFail($productId);

            // Xóa ảnh đại diện
            if ($product->image) {
                $oldImagePath = Str::replaceFirst('storage/', '', $product->image);
                Storage::disk('public')->delete($oldImagePath);
            }

            // Xóa ảnh chi tiết
            foreach ($product->detailImages as $image) {
                $oldImagePath = Str::replaceFirst('storage/', '', $image->image);
                Storage::disk('public')->delete($oldImagePath);
            }

            // Xóa sản phẩm (và các bản ghi liên quan sẽ tự động bị xóa nếu có cascade on delete)
            $product->delete();

            return redirect()->back()->with('success', 'Đã xóa sản phẩm!');
        } catch (\Exception $e) {
            Log::error('Lỗi xóa sản phẩm: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa sản phẩm. Vui lòng thử lại!');
        }
    }

    // ... các phương thức còn lại giữ nguyên ...
    public function revenue(Request $request)
    {
        $query = Product::query();
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('style_id')) {
            $query->where('style_id', $request->style_id);
        }
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $totalRevenue = $query->sum(DB::raw('price * purchases'));
        $totalPurchases = $query->sum('purchases');

        $perPage = (int) $request->input('per_page', 10);

        $products = $query->selectRaw('*, (price * purchases) as revenue')
            ->orderBy('revenue', 'desc')
            ->paginate($perPage)
            ->appends($request->all());
        $categories = Category::orderBy('name')->get();
        $styles = Style::orderBy('name')->get();
        return view('admin.pages.products.revenue', compact('products', 'totalRevenue', 'totalPurchases', 'categories', 'styles'));
    }

    public function getProductJson($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $product->load(['category', 'style', 'details', 'detailImages']);

            return response()->json(['product' => $product]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Đã xảy ra lỗi khi tải dữ liệu chi tiết.',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function getStylesByCategory(Request $request)
    {
        $styles = [];

        if ($request->filled('category_id')) {
            $styleIds = Product::where('category_id', $request->category_id)
                ->select('style_id')
                ->whereNotNull('style_id')
                ->distinct()
                ->pluck('style_id');

            $styles = Style::whereIn('id', $styleIds)->orderBy('name')->get();
        }

        return response()->json($styles);
    }
}
