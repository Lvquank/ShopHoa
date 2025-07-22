<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function __construct()
    {
        // Yêu cầu xác thực cho các hành động thêm, sửa, xóa
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
    }

    /**
     * Lấy danh sách tất cả đánh giá của một sản phẩm.
     * Ai cũng có thể xem.
     */
    public function index($productId)
    {
        $reviews = ProductReview::with('user:id,username,avatar') // Chỉ lấy các trường cần thiết của user
            ->where('product_id', $productId)
            ->latest() // Sắp xếp theo mới nhất
            ->paginate(10); // Phân trang

        return response()->json($reviews);
    }

    /**
     * Lưu một đánh giá mới.
     * Chỉ người dùng đã đăng nhập mới có thể thực hiện.
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = $request->user();

        // Sử dụng updateOrCreate để người dùng chỉ có một đánh giá cho mỗi sản phẩm.
        // Nếu đã có, nó sẽ cập nhật; nếu chưa có, nó sẽ tạo mới.
        $review = ProductReview::updateOrCreate(
            [
                'product_id' => $productId,
                'user_id' => $user->id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return response()->json([
            'message' => 'Cảm ơn bạn đã đánh giá sản phẩm!',
            'review' => $review->load('user:id,username,avatar')
        ], 201); // 201 Created
    }

    /**
     * Cập nhật một đánh giá đã có.
     * Người dùng chỉ có thể cập nhật đánh giá của chính họ.
     */
    public function update(Request $request, ProductReview $review)
    {
        // Authorization: Kiểm tra xem người dùng có phải là chủ của đánh giá không
        if ($request->user()->id !== $review->user_id) {
            return response()->json(['message' => 'Bạn không có quyền thực hiện hành động này.'], 403); // 403 Forbidden
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update($request->only('rating', 'comment'));

        return response()->json([
            'message' => 'Cập nhật đánh giá thành công!',
            'review' => $review->load('user:id,username,avatar')
        ]);
    }

    /**
     * Xóa một đánh giá.
     * Người dùng chỉ có thể xóa đánh giá của chính họ.
     */
    public function destroy(Request $request, ProductReview $review)
    {
        // Authorization: Kiểm tra quyền sở hữu
        if ($request->user()->id !== $review->user_id) {
            return response()->json(['message' => 'Bạn không có quyền thực hiện hành động này.'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Đánh giá đã được xóa.']);
    }
}
