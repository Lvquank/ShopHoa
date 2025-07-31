<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Style;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Áp dụng sắp xếp cho một câu truy vấn.
     * Đây là một hàm trợ giúp để tránh lặp lại code.
     *
     * @param Builder $query
     * @param Request $request
     * @return Builder
     */
    private function applySorting(Builder $query, Request $request): Builder
    {
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'popularity':
                // Giả sử bạn có cột 'purchases' để đếm lượt mua
                $query->orderBy('purchases', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
        }
        return $query;
    }

    /**
     * Hiển thị danh sách tất cả sản phẩm
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->get('sort') === 'top_selling') {
            return $this->getByIsOnTop($request);
        }

        $query = Product::with(['category', 'style']);
        $query = $this->applySorting($query, $request);
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
        $product = Product::with(['category', 'style', 'details.images'])->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Chi tiết sản phẩm',
            'data' => $product
        ]);
    }

    /**
     * Lấy danh sách sản phẩm nổi bật (bán chạy)
     */
    public function getByIsOnTop(Request $request): JsonResponse
    {
        $query = Product::with(['category', 'style'])
            ->where('is_on_top', true);

        $query = $this->applySorting($query, $request);
        $products = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Danh sách sản phẩm nổi bật',
            'data' => $products
        ]);
    }

    /**
     * Lấy danh sách sản phẩm mới
     */
    public function getNewProducts(Request $request): JsonResponse
    {
        $query = Product::with(['category', 'style'])
            ->where('is_new', true);

        $query = $this->applySorting($query, $request);
        $products = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Danh sách sản phẩm mới',
            'data' => $products
        ]);
    }

    /**
     * SỬA LỖI: Thêm lại hàm getByCategory để tương thích với route
     * Hàm này chỉ đơn giản là gọi đến hàm getByCategoryAndStyle mà không có style.
     */
    public function getByCategory(Request $request, $categorySlug): JsonResponse
    {
        return $this->getByCategoryAndStyle($request, $categorySlug, null);
    }

    /**
     * Lấy danh sách sản phẩm theo danh mục và (tùy chọn) phong cách
     */
    public function getByCategoryAndStyle(Request $request, $categorySlug, $styleSlug = null): JsonResponse
    {
        // Bắt đầu câu truy vấn và lọc theo category alias
        $query = Product::with(['category', 'style'])
            ->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('alias', $categorySlug);
            });

        // Nếu có style slug, tiếp tục lọc theo style alias
        if ($styleSlug) {
            $query->whereHas('style', function ($q) use ($styleSlug) {
                $q->where('alias', $styleSlug);
            });
        }

        // Áp dụng sắp xếp
        $query = $this->applySorting($query, $request);
        $products = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Lấy sản phẩm theo danh mục thành công',
            'data' => $products
        ]);
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function search(Request $request): JsonResponse
    {
        $query = Product::with(['category', 'style']);

        if ($request->has('category') && $request->category !== 'all') {
            $categorySlug = $request->category;
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('alias', $categorySlug);
            });
        }

        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        $query = $this->applySorting($query, $request);
        $products = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Kết quả tìm kiếm',
            'data' => $products
        ]);
    }
}
