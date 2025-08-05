<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminCategoryController extends Controller
{
    /**
     * Hiển thị danh sách các danh mục.
     */
    public function index()
    {
        // Lấy danh sách danh mục và đếm số kiểu dáng liên quan
        $categories = Category::withCount('styles')->orderBy('order')->get();
        $styles = Style::withCount('categories')->orderBy('name')->get();

        // Gửi cả 2 biến sang view
        return view('admin.pages.categories.list-category', compact('categories', 'styles'));
    }

    /**
     * Hiển thị form để tạo danh mục mới.
     * Sửa: Đổi tên từ addCategory -> create và gửi danh sách styles sang view.
     */
    public function create()
    {
        // Gửi danh sách categories sang cho view để hiển thị trong dropdown
        $categories = Category::where('status', true)->orderBy('name', 'asc')->get();
        // Giả sử file view của bạn tên là 'add-style.blade.php'
        return view('admin.pages.categories.add-category', compact('categories'));
    }

    /**
     * Chỉ xử lý việc lưu một Danh Mục mới.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'category_alias' => 'required|string|max:255|unique:categories,alias',
        ]);
        $categoryCount = Category::count();
        Category::create([
            'name' => $validated['name'],
            'alias' => $validated['category_alias'],
            'order' => $categoryCount + 1, // Tự động tăng thứ tự
            'status' => true,
        ]);

        return redirect()->route('admin.category.product')->with('success', 'Tạo danh mục mới thành công!');
    }

    /**
     * Hiển thị form để chỉnh sửa một danh mục.
     * Sửa: Đổi tên từ editCategory -> edit và gửi danh sách styles sang view.
     */
    public function edit(Category $category) // Sử dụng Route Model Binding
    {
        $categories = Category::where('id', '!=', $category->id)->orderBy('name')->get();
        return view('admin.pages.categories.edit-category', compact('category', 'categories'));
    }

    /**
     * Cập nhật một danh mục đã có.
     * Sửa: Đổi tên từ updateCategory -> update và dùng sync() để cập nhật quan hệ.
     */
    public function update(Request $request, Category $category)
    {
        // BƯỚC 1: Dùng 'nullable' thay vì 'sometimes'
        // 'nullable' cho phép trường được gửi lên với giá trị rỗng hoặc null.
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'alias' => 'nullable|string|max:255|unique:categories,alias,' . $category->id,
            'order' => 'nullable|integer|min:1',
        ]);

        // BƯỚC 2: Lọc bỏ các giá trị null/rỗng khỏi mảng đã validate
        // Điều này đảm bảo chúng ta chỉ cập nhật những trường mà người dùng thực sự nhập dữ liệu mới.
        // Những trường bị xóa trắng sẽ không được cập nhật, giữ lại giá trị cũ.
        $updateData = collect($validatedData)->filter(function ($value) {
            return $value !== null;
        })->all();


        // BƯỚC 3: Thực hiện cập nhật với dữ liệu đã được lọc
        if (!empty($updateData)) {
            $category->update($updateData);
        }

        // Xử lý riêng cho trường 'status'
        if ($request->has('status')) {
            $category->status = $request->boolean('status');
        } else {
            // Nếu checkbox không được tick, request sẽ không có trường 'status'
            // Ta cần gán nó là false một cách tường minh.
            $category->status = false;
        }

        $category->save(); // Lưu lại tất cả thay đổi (cả status và các trường khác)

        return redirect()->route('admin.category.product')->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Xóa một danh mục.
     * Sửa: Đổi tên từ deleteCategory -> destroy và dùng detach() để xóa liên kết.
     */
    public function destroy($categoryId)
    {
        // Tìm category theo ID
        $category = Category::find($categoryId);

        if (!$category) {
            return redirect()->back()->with('error', 'Không tìm thấy danh mục!');
        }

        // Kiểm tra products
        $productsCount = DB::table('products')->where('category_id', $category->id)->count();

        if ($productsCount > 0) {
            return redirect()->back()->with('error', "Không thể xóa! Có {$productsCount} sản phẩm đang sử dụng danh mục này.");
        }

        try {
            DB::transaction(function () use ($category) {
                // Xóa styles relationship
                $category->styles()->detach();

                // Xóa category
                $deleteResult = $category->delete();

                if (!$deleteResult) {
                    throw new \Exception('Không thể xóa danh mục từ database');
                }
            });

            return redirect()->back()->with('success', 'Đã xóa danh mục thành công!');
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), 'foreign key constraint')) {
                return redirect()->back()->with('error', 'Không thể xóa danh mục vì có dữ liệu liên quan!');
            }

            return redirect()->back()->with('error', 'Lỗi database: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Thay đổi trạng thái của danh mục.
     */
    public function changeStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->boolean('status');
        $category->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật trạng thái thành công!']);
    }
}
