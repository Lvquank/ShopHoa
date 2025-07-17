<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with('details');

        // Sắp xếp theo tiêu chí
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'popularity':
                $query->orderBy('purchases', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Danh sách sản phẩm',
            'data' => $products
        ]);
    }

    /**
     * Lấy chi tiết một sản phẩm
     */
    public function show($id): JsonResponse
    {
        $product = Product::with('details')->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Chi tiết sản phẩm',
            'data' => $product
        ]);
    }

    /**
     * Lấy danh sách sản phẩm theo danh mục
     */
    public function getByCategory($category, Request $request): JsonResponse
    {
        $query = Product::where('category', $category);

        if ($request->has('exclude')) {
            $query->where('id', '!=', $request->exclude);
        }

        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'popularity':
                $query->orderBy('purchases', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Danh sách sản phẩm theo danh mục',
            'data' => $products
        ]);
    }

    /**
     * Lấy danh sách sản phẩm nổi bật
     */
    public function getByIsOnTop(): JsonResponse
    {
        $products = Product::with('details')
            ->where('is_on_top', true)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Danh sách sản phẩm nổi bật',
            'data' => $products
        ]);
    }

    /**
     * Lấy danh sách sản phẩm theo danh mục và phong cách
     */
    public function getByCategoryAndStyle($category, $style = null): JsonResponse
    {
        $query = Product::where('category', $category);

        if ($style) {
            $query->where('style', $style);
        }

        $products = $query->get();

        return response()->json([
            'success' => true,
            'message' => $style ? 'Danh sách sản phẩm theo danh mục và phong cách' : 'Danh sách sản phẩm theo danh mục',
            'data' => $products
        ]);
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function search(Request $request): JsonResponse
    {
        $query = Product::query();

        // Xử lý đặc biệt cho danh mục "bán chạy nhất"
        if ($request->category === 'ban-chay-nhat') {
            return $this->getByIsOnTop();
        }

        // Lọc theo danh mục
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Tìm kiếm theo từ khóa
        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        $products = $query->with('details')->get();

        return response()->json([
            'success' => true,
            'message' => 'Kết quả tìm kiếm',
            'data' => $products
        ]);
    }
}
