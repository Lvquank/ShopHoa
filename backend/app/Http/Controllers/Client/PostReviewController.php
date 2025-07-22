<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PostReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostReviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Yêu cầu xác thực cho các hành động thêm, sửa, xóa
        // Ai cũng có thể xem danh sách bình luận (index)
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
    }

    /**
     * Lấy danh sách tất cả bình luận của một bài viết.
     *
     * @param  int  $postId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($postId)
    {
        $reviews = PostReview::with('user:id,username')
            ->where('post_id', $postId)
            ->latest() // Sắp xếp theo mới nhất
            ->paginate(15); // Phân trang

        return response()->json($reviews);
    }


    /**
     * Lưu một bình luận mới vào cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Thêm validation cho website
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|min:5|max:1000',
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'website' => 'nullable|url|max:255', // Thêm quy tắc xác thực cho website
        ]);

        $user = $request->user();

        // Tạo và lưu bình luận
        $review = PostReview::create([
            'post_id' => $request->post_id,
            'user_id' => $user->id,
            'name'    => $request->name,
            'email'   => $request->email,
            'comment' => $request->comment,
            'website' => $request->website, // SỬA LỖI: Thêm website vào đây
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bình luận của bạn đã được gửi thành công!',
            'data'    => $review->load('user:id,username')
        ], 201);
    }

    /**
     * Cập nhật một bình luận đã có.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostReview  $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, PostReview $review)
    {
        // Phân quyền: Kiểm tra xem người dùng có phải là chủ của bình luận không
        if ($request->user()->id !== $review->user_id) {
            return response()->json(['message' => 'Bạn không có quyền thực hiện hành động này.'], 403);
        }

        $request->validate([
            'comment' => 'required|string|min:5|max:1000',
        ]);

        $review->update($request->only('comment'));

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật bình luận thành công!',
            'data'    => $review->load('user:id,username')
        ]);
    }

    /**
     * Xóa một bình luận.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostReview  $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, PostReview $review)
    {
        // Phân quyền: Kiểm tra quyền sở hữu
        if ($request->user()->id !== $review->user_id) {
            return response()->json(['message' => 'Bạn không có quyền thực hiện hành động này.'], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bình luận đã được xóa.'
        ]);
    }
}
