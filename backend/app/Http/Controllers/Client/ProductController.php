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
        // Tải sẵn các mối quan hệ 'category' và 'style' để tối ưu hóa truy vấn
        $query = Product::with(['category', 'style']);

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
        // === PHẦN ĐƯỢC CẬP NHẬT ===
        // Tải sẵn các mối quan hệ lồng nhau:
        // 'category', 'style'
        // 'details' (bảng product_details)
        // 'details.images' (bảng product_detail_images, liên quan đến từng product_details)
        $product = Product::with([
            'category',
            'style',
            'details.images' // Tải chi tiết và hình ảnh chi tiết của sản phẩm
        ])->find($id);

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
    public function getByCategory($categorySlug, Request $request): JsonResponse
    {
        // Sử dụng whereHas để lọc sản phẩm dựa trên 'name' của category liên quan
        $query = Product::whereHas('category', function ($q) use ($categorySlug) {
            $q->where('alias', $categorySlug);
        });

        if ($request->has('exclude')) {
            $query->where('id', '!=', $request->exclude);
        }

        // Tải các mối quan hệ sau khi lọc
        $query->with(['category', 'style']);

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
        $products = Product::with(['category', 'style'])
            ->where('is_on_top', true)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Danh sách sản phẩm nổi bật',
            'data' => $products
        ]);
    }

    /**
     * Lấy danh sách sản phẩm mới
     */
    public function getNewProducts(): JsonResponse
    {
        $products = Product::with(['category', 'style'])
            ->where('is_new', true)
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm mới',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Danh sách sản phẩm mới',
            'data'    => $products
        ]);
    }

    /**
     * Lấy danh sách sản phẩm theo danh mục và phong cách
     */
    public function getByCategoryAndStyle($categorySlug, $styleSlug = null): JsonResponse
    {
        // Lọc theo category alias
        $query = Product::whereHas('category', function ($q) use ($categorySlug) {
            $q->where('alias', $categorySlug);
        });

        // Nếu có style, lọc tiếp theo style alias
        if ($styleSlug) {
            $query->whereHas('style', function ($q) use ($styleSlug) {
                $q->where('alias', $styleSlug);
            });
        }

        $products = $query->with(['category', 'style'])->get();

        return response()->json([
            'success' => true,
            'message' => $styleSlug ? 'Danh sách sản phẩm theo danh mục và phong cách' : 'Danh sách sản phẩm theo danh mục',
            'data' => $products
        ]);
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function search(Request $request): JsonResponse
    {
        $query = Product::query();

        // Xử lý đặc biệt cho danh mục "bán chạy nhất" (is_on_top)
        if ($request->category === 'ban-chay-nhat') {
            return $this->getByIsOnTop();
        }

        // Lọc theo danh mục nếu có và khác 'all'
        if ($request->has('category') && $request->category !== 'all') {
            $categorySlug = $request->category;
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('alias', $categorySlug);
            });
        }

        // Tìm kiếm theo từ khóa
        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        $products = $query->with(['category', 'style'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Kết quả tìm kiếm',
            'data' => $products
        ]);
    }
}
