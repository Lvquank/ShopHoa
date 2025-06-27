<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm
     */
    public function index()
    {
        $products = Product::with('details')->get();
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
}
