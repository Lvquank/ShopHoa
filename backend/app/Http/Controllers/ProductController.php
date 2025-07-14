<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm
     */
    public function index(Request $request)
    {
        $query = Product::with('details');

        // Sắp xếp theo tiêu chí
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popularity':
                    $query->orderBy('purchases', 'desc'); // Sắp xếp theo số lượt mua
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc'); // Giá thấp đến cao
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc'); // Giá cao đến thấp
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc'); // Mới nhất
                    break;
                default:
                    $query->orderBy('created_at', 'desc'); // Mặc định sắp xếp theo mới nhất
            }
        } else {
            $query->orderBy('created_at', 'desc'); // Mặc định sắp xếp theo mới nhất
        }

        $products = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Product list',
            'data' => $products
        ], 200);
    }

    /**
     * Hiển thị form tạo mới (nếu là web app, còn API thì thường không dùng)
     */
    public function create()
    {
        //
    }

    /**
     * Lưu sản phẩm mới vào database
     */
    public function store(Request $request)
    {
        try {
            $product = Product::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hiển thị một sản phẩm cụ thể
     */
    public function show($id)
    {
        $product = Product::with('details')->find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Product details',
            'data' => $product
        ], 200);
    }

    /**
     * Hiển thị form sửa sản phẩm (chỉ dùng cho web app)
     */
    public function edit($id)
    {
        //
    }

    /**
     * Cập nhật thông tin sản phẩm
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'data' => null
            ], 404);
        }
        $product->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    /**
     * Xóa sản phẩm
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'data' => null
            ], 404);
        }
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
            'data' => null
        ], 200);
    }

    /**
     * Lấy danh sách sản phẩm theo category và sắp xếp theo tiêu chí
     * @param string $category
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByCategory($category, Request $request)
    {
        $query = Product::where('category', $category);

        // Loại trừ sản phẩm nếu có exclude ID
        if ($request->has('exclude')) {
            $query->where('id', '!=', $request->exclude);
        }

        // Sắp xếp theo tiêu chí
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popularity':
                    $query->orderBy('purchases', 'desc'); // Sắp xếp theo số lượt mua
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc'); // Giá thấp đến cao
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc'); // Giá cao đến thấp
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc'); // Mới nhất
                    break;
                default:
                    $query->orderBy('created_at', 'desc'); // Mặc định sắp xếp theo mới nhất
            }
        } else {
            $query->orderBy('created_at', 'desc'); // Mặc định sắp xếp theo mới nhất
        }

        $products = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Product list by category',
            'data' => $products
        ], 200);
    }

    /**
     * Lấy danh sách sản phẩm chỉ có is_on_top = true
     */
    public function getByIsOnTop()
    {
        $products = Product::with('details')->where('is_on_top', 1)->get();
        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product list where is_on_top is true',
            'data' => $products
        ], 200);
    }

    /**
     * Lấy danh sách sản phẩm theo category và style nếu có
     * /products/category/{category}/{style?}
     */
    public function getByCategoryAndStyle($category, $style = null)
    {
        $query = Product::where('category', $category);
        if ($style) {
            $query->where('style', $style);
        }
        $products = $query->get();
        return response()->json([
            'success' => true,
            'message' => $style ? 'Product list by category and style' : 'Product list by category',
            'data' => $products
        ], 200);
    }

    /**
     * Tìm kiếm sản phẩm theo category và keyword
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = Product::query();

        // Xử lý đặc biệt cho category "ban-chay-nhat"
        if ($request->has('category') && $request->category === 'ban-chay-nhat') {
            $products = Product::with('details')->where('is_on_top', 1)->get();
        } else {
            // Tìm theo category thông thường
            if ($request->has('category') && $request->category !== 'all') {
                $query->where('category', $request->category);
            }

            // Tìm theo keyword nếu có
            if ($request->has('keyword') && !empty($request->keyword)) {
                $keyword = $request->keyword;
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'LIKE', "%{$keyword}%")
                        ->orWhere('description', 'LIKE', "%{$keyword}%");
                });
            }

            $products = $query->with('details')->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Search results',
            'data' => $products
        ], 200);
    }
}
