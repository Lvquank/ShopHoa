<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Style;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule; // THÊM: Import Rule class để tạo validation phức hợp

class AdminStyleController extends Controller
{
    public function index()
    {
        // Lấy danh sách các Kiểu Dáng, kèm theo thông tin Danh Mục liên quan.
        $styles = Style::with('category')->latest()->paginate(15);

        // Trả về đúng view của Kiểu Dáng.
        return view('admin.pages.styles.list-style', compact('styles'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->orderBy('name', 'asc')->get();
        return view('admin.pages.styles.add-style', compact('categories'));
    }

    public function store(Request $request)
    {
        // Trường hợp 1: Người dùng chọn "Tạo Danh Mục Mới"
        if ($request->input('category_id') == '0') {

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'category_alias' => 'required|string|max:255|unique:categories,alias',
            ]);

            $category = new Category();
            $category->name = $validated['name'];
            $category->alias = $validated['category_alias'];
            $category->order = 99;
            $category->status = true;
            $category->save();

            return redirect()->route('admin.category.product')->with('success', 'Tạo danh mục mới thành công!');
        } else {
            // Trường hợp 2: Người dùng chọn một danh mục có sẵn để tạo Kiểu Dáng
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                // SỬA LỖI: Thay đổi quy tắc unique cho alias
                'alias' => [
                    'required',
                    'string',
                    'max:255',
                    // Alias phải là duy nhất trong phạm vi của category_id được chọn
                    Rule::unique('styles')->where(function ($query) use ($request) {
                        return $query->where('category_id', $request->category_id);
                    }),
                ],
            ]);

            Style::create($validated);

            return redirect()->route('admin.styles.index')->with('success', 'Tạo kiểu dáng thành công!');
        }
    }

    public function edit(Style $style)
    {
        $categories = Category::where('status', true)->orderBy('name', 'asc')->get();
        return view('admin.pages.styles.edit-style', compact('style', 'categories'));
    }

    public function update(Request $request, Style $style)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            // SỬA LỖI: Áp dụng quy tắc unique tương tự cho hàm update
            'alias' => [
                'required',
                'string',
                'max:255',
                // Alias phải là duy nhất trong phạm vi của category_id,
                // nhưng bỏ qua chính style đang được sửa
                Rule::unique('styles')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id);
                })->ignore($style->id),
            ],
        ]);

        $style->update($validated);

        return redirect()->route('admin.styles.index')->with('success', 'Cập nhật kiểu dáng thành công!');
    }

    public function destroy(Style $style)
    {
        if ($style->products()->exists()) {
            return redirect()->back()->with('error', 'Không thể xóa kiểu dáng này vì vẫn còn sản phẩm liên quan.');
        }

        $style->delete();

        return redirect()->back()->with('success', 'Đã xóa kiểu dáng thành công!');
    }
}
