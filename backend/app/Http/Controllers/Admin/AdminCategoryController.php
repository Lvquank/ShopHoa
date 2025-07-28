<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('styles')
            ->orderBy('order', 'asc')
            ->paginate(10);

        return view('admin.pages.categories.list-category', compact('categories'));
    }

    /**
     * SỬA LỖI: Thêm logic để lấy và gửi biến $categories sang view.
     */
    public function addCategory()
    {
        // Lấy tất cả các danh mục để hiển thị trong dropdown (nếu có)
        $categories = Category::orderBy('name', 'asc')->get();

        // Trả về view và truyền biến $categories sang
        return view('admin.pages.categories.add-category', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'alias' => 'required|string|unique:categories,alias|max:255',
            'order' => 'required|integer|min:1',
            'style_name' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $category = Category::create([
                'name' => $validated['name'],
                'alias' => $validated['alias'],
                'order' => $validated['order'],
                'status' => $request->boolean('status'),
            ]);

            if ($request->filled('style_name')) {
                Style::create([
                    'name' => $request->input('style_name'),
                    'alias' => Str::slug($request->input('style_name') . '-' . $category->id),
                    'category_id' => $category->id,
                ]);
            }
        });

        return redirect()->route('admin.category.product')->with('success', 'Tạo danh mục thành công!');
    }

    public function editCategory(string $categoryId)
    {
        // SỬA LỖI: Cần gửi cả danh sách categories sang cho view sửa
        $category = Category::findOrFail($categoryId);
        $allCategories = Category::orderBy('name', 'asc')->get(); // Lấy danh sách để chọn lại danh mục cha
        return view('admin.pages.categories.edit-category', [
            'category' => $category,
            'categories' => $allCategories
        ]);
    }

    public function updateCategory(Request $request)
    {
        $categoryId = $request->input('id');

        $validated = $request->validate([
            'id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'alias' => 'required|string|max:255|unique:categories,alias,' . $categoryId,
            'order' => 'required|integer|min:1',
        ]);

        $category = Category::findOrFail($categoryId);

        $updateData = $request->only(['name', 'alias', 'order']);
        $updateData['status'] = $request->boolean('status');

        $category->update($updateData);

        return redirect()->route('admin.category.product')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function deleteCategory(string $categoryId)
    {
        $category = Category::findOrFail($categoryId);

        DB::transaction(function () use ($category) {
            $category->styles()->delete();
            $category->delete();
        });

        return redirect()->back()->with('success', 'Đã xóa danh mục và tất cả các kiểu dáng liên quan thành công!');
    }

    public function changeStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->boolean('status');
        $category->save();

        return response()->json(['message' => 'Cập nhật trạng thái thành công!']);
    }
}
