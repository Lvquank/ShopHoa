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
use Illuminate\Support\Str; // THÊM: Import Str để tạo slug

class AdminProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('style_id')) {
            $query->where('style_id', $request->style_id);
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $perPage = (int) $request->input('per_page', 10);
        $products = $query->with(['category', 'style'])->orderBy('order', 'asc')->paginate($perPage)->appends($request->all());

        return view('admin.pages.products.list-product', compact('products'));
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
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:products,title',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer|exists:categories,id',
            'style_id' => 'nullable|integer|exists:styles,id',
            'description' => 'nullable|string',
            'tag' => 'nullable|string|max:255',
            'order' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'title.required' => 'Tên sản phẩm không được bỏ trống.',
            'title.unique' => 'Tên sản phẩm này đã tồn tại.',
            'price.required' => 'Giá sản phẩm không được bỏ trống.',
            'category_id.required' => 'Bạn phải chọn danh mục sản phẩm.',
            'image.required' => 'Hình ảnh sản phẩm không được bỏ trống.',
        ]);

        try {
            $product = new Product();
            $product->title = $request->input('title');
            $product->price = $request->input('price');
            $product->category_id = $request->input('category_id');
            $product->style_id = $request->input('style_id');
            $product->description = $request->input('description');
            $product->tag = $request->input('tag');
            $product->order = $request->input('order');
            $product->is_on_top = $request->has('is_on_top');
            $product->is_new = $request->has('is_new');
            $product->purchases = 0;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                // SỬA LỖI: Thêm tiền tố 'storage/' vào đường dẫn trước khi lưu
                $path = $image->store('products', 'public');
                $product->image = 'storage/' . $path;
            }

            $product->save();

            return redirect()->route('admin.product')->with('success', 'Tạo sản phẩm thành công!');
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo sản phẩm. Vui lòng thử lại!')->withInput();
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $product = Product::findOrFail($request->id);
            $type = $request->type;

            if (in_array($type, ['is_on_top', 'is_new'])) {
                $product->$type = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
                $product->save();
                return response()->json(['success' => true]);
            }

            return response()->json(['error' => 'Invalid status type.'], 400);
        } catch (\Exception $e) {
            Log::error('Error changing product status: ' . $e->getMessage());
            return response()->json(['error' => true]);
        }
    }

    public function editProduct($productId)
    {
        // Tìm sản phẩm, nếu không thấy sẽ báo lỗi 404
        $product = Product::with(['category', 'style'])->findOrFail($productId);

        // SỬA LỖI: Bỏ logic cha-con và lấy tất cả danh mục
        $categories = Category::all();

        // Lấy TẤT CẢ các kiểu dáng.
        $styles = Style::all();

        // Trả về view và truyền các biến cần thiết
        return view('admin.pages.products.edit-product', compact(
            'product',
            'categories', // <-- Truyền biến $categories
            'styles'
        ));
    }

    public function updateProduct(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:products,title,' . $product->id,
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer|exists:categories,id',
            'style_id' => 'nullable|integer|exists:styles,id',
            'description' => 'nullable|string',
            'tag' => 'nullable|string|max:255',
            'order' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'title.required' => 'Tên sản phẩm không được bỏ trống.',
            'price.required' => 'Giá sản phẩm không được bỏ trống.',
            'category_id.required' => 'Bạn phải chọn danh mục sản phẩm.',
        ]);

        try {
            $product->title = $request->input('title');
            $product->price = $request->input('price');
            $product->category_id = $request->input('category_id');
            $product->style_id = $request->input('style_id');
            $product->description = $request->input('description');
            $product->tag = $request->input('tag');
            $product->order = $request->input('order');
            $product->is_on_top = $request->has('is_on_top');
            $product->is_new = $request->has('is_new');

            if ($request->hasFile('image')) {
                // SỬA LỖI: Xóa ảnh cũ đúng cách bằng cách loại bỏ tiền tố 'storage/'
                if ($product->image) {
                    $oldImagePath = Str::replaceFirst('storage/', '', $product->image);
                    Storage::disk('public')->delete($oldImagePath);
                }
                // Lưu ảnh mới với tiền tố 'storage/'
                $path = $request->file('image')->store('products', 'public');
                $product->image = 'storage/' . $path;
            }

            $product->save();

            return redirect()->route('admin.product')->with('success', 'Đã cập nhật sản phẩm!');
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi sửa sản phẩm. Vui lòng thử lại!')->withInput();
        }
    }

    public function deleteProduct($productId)
    {
        try {
            $product = Product::findOrFail($productId);

            // SỬA LỖI: Xóa ảnh đúng cách bằng cách loại bỏ tiền tố 'storage/'
            if ($product->image) {
                $oldImagePath = Str::replaceFirst('storage/', '', $product->image);
                Storage::disk('public')->delete($oldImagePath);
            }

            $product->delete();

            return redirect()->back()->with('success', 'Đã xóa sản phẩm!');
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa sản phẩm. Vui lòng thử lại!');
        }
    }

    public function revenue(Request $request)
    {
        $query = Product::query();

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

        return view('admin.pages.products.revenue', compact('products', 'totalRevenue', 'totalPurchases'));
    }
    // Trong file app/Http/Controllers/Admin/AdminProductController.php

    /**
     * Trả về dữ liệu chi tiết của sản phẩm dưới dạng JSON.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductJson($productId)
    {
        try {
            // Bước 1: Tìm sản phẩm để chắc chắn nó tồn tại.
            // Nếu không có sản phẩm, dòng này sẽ báo lỗi và dừng lại.
            $product = Product::findOrFail($productId);

            // Bước 2: Tải các mối quan hệ. 
            // Nếu có lỗi ở bất kỳ mối quan hệ nào, nó sẽ bị bắt ở khối catch.
            $product->load(['category', 'style', 'details', 'detailImages']);

            // Nếu mọi thứ thành công, trả về dữ liệu
            return response()->json(['product' => $product]);
        } catch (\Exception $e) {
            // Trả về một thông báo lỗi chi tiết hơn để debug
            // Đây là phần quan trọng nhất
            return response()->json([
                'error' => 'Đã xảy ra lỗi khi tải dữ liệu chi tiết.',
                'message' => $e->getMessage(), // Dòng này sẽ hiển thị lỗi thật sự
                'trace' => $e->getTraceAsString() // Dòng này cung cấp thêm thông tin về nơi xảy ra lỗi
            ], 500); // Trả về lỗi 500 (Internal Server Error)
        }
    }
}
