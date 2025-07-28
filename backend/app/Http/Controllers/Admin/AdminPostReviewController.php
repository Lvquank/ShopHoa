<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostReview; // Đảm bảo bạn đã có model này
use Illuminate\Http\Request;

class AdminPostReviewController extends Controller
{
    /**
     * Hiển thị danh sách các bình luận bài viết.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Lấy tất cả các review, sắp xếp theo ngày tạo mới nhất
        // Sử dụng with('post') để tải trước thông tin bài viết, tránh N+1 query
        $reviews = PostReview::with('post')->latest()->get();

        return view('admin.pages.post-review.list-post-review', compact('reviews'));
    }

    /**
     * Hiển thị form để chỉnh sửa một bình luận cụ thể.
     *
     * @param  int  $reviewId
     * @return \Illuminate\View\View
     */
    public function edit($reviewId)
    {
        // Tìm review theo ID, nếu không thấy sẽ báo lỗi 404
        // Tải trước thông tin bài viết liên quan
        $review = PostReview::with('post')->findOrFail($reviewId);

        return view('admin.pages.post-review.edit-post-review', compact('review'));
    }

    /**
     * Cập nhật thông tin bình luận trong cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $reviewId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $reviewId)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'comment' => 'required|string',
        ]);

        // Tìm review
        $review = PostReview::findOrFail($reviewId);

        // Cập nhật các trường
        $review->name = $request->input('name');
        $review->email = $request->input('email');
        $review->website = $request->input('website');
        $review->comment = $request->input('comment');
        $review->save();

        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('admin.pages.post-review.list')->with('success', 'Cập nhật bình luận thành công!');
    }

    /**
     * Xóa một bình luận khỏi cơ sở dữ liệu.
     *
     * @param  int  $reviewId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($reviewId)
    {
        // Tìm và xóa review
        $review = PostReview::findOrFail($reviewId);
        $review->delete();

        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('admin.pages.post-review.list')->with('success', 'Đã xóa bình luận thành công!');
    }
}
