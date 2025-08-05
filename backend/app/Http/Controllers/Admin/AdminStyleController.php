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
        $styles = Style::with('categories')->latest()->paginate(11);
        return view('admin.pages.styles.list-style', compact('styles'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->orderBy('name', 'asc')->get();
        return view('admin.pages.categories.add-category', compact('categories'));
    }

    /**
     * Chỉ xử lý việc lưu một Kiểu Dáng mới và liên kết nó.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255|unique:styles,name',
            'alias' => 'required|string|max:255|unique:styles,alias',
        ]);

        DB::beginTransaction();
        try {
            $style = Style::create([
                'name' => $validated['name'],
                'alias' => $validated['alias'],
                'order' => 1,
            ]);

            $style->categories()->attach($validated['category_id']);

            DB::commit();
            return redirect()->route('admin.styles.index')->with('success', 'Tạo kiểu dáng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Style $style)
    {
        // Lấy tất cả danh mục để hiển thị trong ô chọn
        $categories = Category::orderBy('name', 'asc')->get();

        // Lấy danh sách ID của các danh mục mà kiểu dáng này đang thuộc về
        $currentCategoryIds = $style->categories->pluck('id')->toArray();

        return view('admin.pages.styles.edit-style', compact('style', 'categories', 'currentCategoryIds'));
    }

    /**
     * Cập nhật một kiểu dáng đã có trong database.
     */
    public function update(Request $request, Style $style)
    {
        // Validate dữ liệu cơ bản của style và cả mảng ID của category
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'alias' => 'nullable|string|max:255|unique:styles,alias,' . $style->id,
            'order' => 'nullable|integer|min:1',
            'category_ids' => 'nullable|array', // category_ids phải là một mảng
            'category_ids.*' => 'exists:categories,id', // Mỗi ID trong mảng phải tồn tại trong bảng categories
        ]);

        DB::transaction(function () use ($style, $request, $validatedData) {
            // 1. Lọc và cập nhật các trường của style (name, alias, order)
            $updateData = collect($validatedData)->only(['name', 'alias', 'order'])->filter()->all();
            if (!empty($updateData)) {
                $style->update($updateData);
            }

            // 2. Dùng sync() để đồng bộ hóa quan hệ với các danh mục.
            // Nó sẽ tự động thêm/xóa các liên kết trong bảng `category_style`.
            $style->categories()->sync($request->input('category_ids', []));
        });

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
