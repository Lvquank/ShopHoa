<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $categories = Category::orderBy('name')->get();
        return view('admin.pages.categories.add-category', compact('categories'));
    }

    /**
     * Lưu một danh mục mới vào cơ sở dữ liệu.
     * Sửa: Xử lý logic quan hệ nhiều-nhiều.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'alias' => 'required|string|unique:categories,alias|max:255',
            'order' => 'required|integer|min:1',
            'style_ids' => 'nullable|array', // Dùng để nhận danh sách ID của các kiểu dáng
            'style_ids.*' => 'exists:styles,id' // Đảm bảo mỗi ID đều tồn tại trong bảng styles
        ]);

        DB::transaction(function () use ($request, $validated) {
            $category = Category::create([
                'name' => $validated['name'],
                'alias' => $validated['alias'],
                'order' => $validated['order'],
                'status' => $request->boolean('status'),
            ]);

            // Nếu có chọn kiểu dáng, dùng attach() để liên kết chúng
            if (!empty($validated['style_ids'])) {
                $category->styles()->attach($validated['style_ids']);
            }
        });

        return redirect()->route('admin.categories.index')->with('success', 'Tạo danh mục thành công!');
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
    public function update(Request $request, Category $category) // Sử dụng Route Model Binding
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'alias' => 'required|string|max:255|unique:categories,alias,' . $category->id,
            'order' => 'required|integer|min:1',
            'style_ids' => 'nullable|array',
            'style_ids.*' => 'exists:styles,id'
        ]);

        DB::transaction(function () use ($request, $category, $validated) {
            $category->update([
                'name' => $validated['name'],
                'alias' => $validated['alias'],
                'order' => $validated['order'],
                'status' => $request->boolean('status'),
            ]);

            // Dùng sync() để đồng bộ hóa các kiểu dáng.
            // Nó sẽ tự động thêm/xóa các liên kết trong bảng category_style.
            $category->styles()->sync($validated['style_ids'] ?? []);
        });

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Xóa một danh mục.
     * Sửa: Đổi tên từ deleteCategory -> destroy và dùng detach() để xóa liên kết.
     */
    public function destroy(Category $category) // Sử dụng Route Model Binding
    {
        DB::transaction(function () use ($category) {
            // Dùng detach() để xóa tất cả các liên kết trong bảng category_style
            // mà không ảnh hưởng đến các bản ghi trong bảng styles.
            $category->styles()->detach();
            $category->delete();
        });

        return redirect()->back()->with('success', 'Đã xóa danh mục thành công!');
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
