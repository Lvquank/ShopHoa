<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Style;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Lấy danh sách tất cả các danh mục.
     * Sử dụng eager loading 'with('styles')' để lấy luôn các style liên quan,
     * tránh vấn đề N+1 query và tăng hiệu năng.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $categories = Category::where('status', 1)
                ->with('styles') // Tải các style liên quan
                ->orderBy('order', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories,
                'message' => 'Lấy danh sách danh mục thành công.'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi xảy ra, không thể lấy danh sách danh mục.'
            ], 500); // Trả về lỗi 500 Internal Server Error
        }
    }

    /**
     * Lấy danh sách tất cả các style.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStyles(): JsonResponse
    {
        try {
            $styles = Style::orderBy('order', 'asc')->get();

            return response()->json([
                'success' => true,
                'data' => $styles,
                'message' => 'Lấy danh sách mẫu thành công.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi xảy ra, không thể lấy danh sách các mẫu.'
            ], 500);
        }
    }
    public function show($category_alias, $style_alias = null)
    {
        // Tìm category dựa trên alias
        $category = Category::where('alias', $category_alias)->first();

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy danh mục'], 404);
        }

        // KỊCH BẢN 2: Nếu có cả style_alias
        if ($style_alias) {
            $style = Style::where('alias', $style_alias)->first();

            if (!$style) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy kiểu dáng'], 404);
            }

            // Lấy description từ bảng trung gian `category_style`
            $pivotData = DB::table('category_style')
                ->where('category_id', $category->id)
                ->where('style_id', $style->id)
                ->first();

            // Tạo một object mới để trả về
            $data = [
                'name' => $category->name,
                'style_name' => $style->name,
                'description' => $pivotData ? $pivotData->description : $category->description, // Lấy desc từ pivot, nếu không có thì lấy của category cha
            ];

            return response()->json(['success' => true, 'data' => $data]);
        }

        // KỊCH BẢN 1: Nếu chỉ có category_alias
        // Trả về toàn bộ thông tin của category, bao gồm description từ bảng `categories`
        return response()->json(['success' => true, 'data' => $category]);
    }
}
