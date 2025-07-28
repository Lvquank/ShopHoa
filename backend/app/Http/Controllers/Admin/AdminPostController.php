<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // THÊM
use Illuminate\Support\Str;             // THÊM

class AdminPostController extends Controller
{
    // ... các hàm xử lý Category không thay đổi ...
    // danh mục bài viết
    public function index()
    {
        $categories = PostCategory::orderBy('order', 'asc')->get();
        return view('admin.pages.post-categories.list-post-category', compact('categories'));
    }

    public function addCategory()
    {
        return view('admin.pages.post-categories.add-post-category');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'alias' => 'required|string|unique:post_categories,alias',
            'order' => 'required|integer',
            'status' => 'nullable|boolean',
        ], [
            'name.required' => 'Tên danh mục không được bỏ trống.',
            'alias.required' => 'Đường dẫn danh mục không được bỏ trống.',
            'alias.unique' => 'Đường dẫn đã bị trùng với danh mục khác.',
            'order.required' => 'Thứ tự hiển thị không được bỏ trống.',
        ]);
        $validated['status'] = $request->has('status') ? true : false;

        try {
            PostCategory::create($validated);
            return redirect()->route('admin.category.post')->with('success', 'Tạo danh mục thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.category.post')->with('error', 'Có lỗi xảy ra khi tạo danh mục. Vui lòng thử lại!');
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $category = PostCategory::findOrFail($request->id);
            $category->status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
            $category->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => true]);
        }
    }

    public function editCategory($categoryId)
    {
        $category = PostCategory::findOrFail($categoryId);
        return view('admin.pages.post-categories.edit-post-category', compact('category'));
    }

    public function updateCategory(Request $request, $categoryId)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'alias' => 'required|string|unique:post_categories,alias,' . $categoryId . ',id',
            'order' => 'required|integer',
            'status' => 'nullable|boolean',
        ], [
            'name.required' => 'Tên menu không được bỏ trống.',
            'alias.required' => 'Đường dẫn menu không được bỏ trống.',
            'alias.unique' => 'Đường dẫn đã bị trùng với menu khác.',
            'order.required' => 'Thứ tự hiển thị không được bỏ trống.',
        ]);
        $validated['status'] = $request->has('status') ? true : false;

        try {
            $category = PostCategory::findOrFail($categoryId);
            $category->update($validated);
            return redirect()->route('admin.category.post')->with('success', 'sửa danh mục thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.category.post')->with('error', 'Có lỗi xảy ra khi sửa danh mục. Vui lòng thử lại!');
        }
    }

    public function deleteCategory($categoryId)
    {
        $category = PostCategory::findOrFail($categoryId);
        try {
            $category->delete();
            return redirect()->back()->with('success', 'Đã xóa danh mục!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa danh mục. Vui lòng thử lại!');
        }
    }

    // =================================================================
    // BÀI VIẾT
    // =================================================================
    public function post(Request $request)
    {
        $query = Post::with('category');

        if ($request->filled('post_category_id')) {
            $query->where('post_category_id', $request->post_category_id);
        }
        if ($request->filled('name')) {
            $query->where('title', 'like', '%' . $request->name . '%');
        }

        $perPage = (int) $request->input('per_page', 10);
        $posts = $query->orderBy('created_at', 'desc')->paginate($perPage)->appends($request->all());
        $categories = PostCategory::all();

        return view('admin.pages.post.list-post', compact('posts', 'categories'));
    }

    public function changeStatusPost(Request $request)
    {
        try {
            $post = Post::findOrFail($request->id);
            $type = $request->type;
            if (in_array($type, ['is_featured'])) { // Chỉ cho phép thay đổi các cột an toàn
                $post->$type = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
                $post->save();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'Invalid type'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => true]);
        }
    }

    public function addPost()
    {
        $categories = PostCategory::get();
        return view('admin.pages.post.add-post', compact('categories'));
    }

    public function storePost(Request $request)
    {
        // ... hàm storePost đã đúng, giữ nguyên ...
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'author' => 'required|string|max:255',
            'post_category_id' => 'required|exists:post_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        try {
            $postData = $request->only(['title', 'author', 'post_category_id', 'title_seo', 'description', 'content']);
            $postData['is_featured'] = $request->has('is_featured') ? 1 : 0;

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('posts', 'public');
                $postData['image'] = 'storage/' . $path;
            }

            $post = Post::create($postData);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $galleryFile) {
                    $path = $galleryFile->store('post_gallery', 'public');
                    $post->images()->create([
                        'url' => 'storage/' . $path,
                        'caption' => pathinfo($galleryFile->getClientOriginalName(), PATHINFO_FILENAME),
                    ]);
                }
            }

            return redirect()->route('admin.post')->with('success', 'Tạo bài viết thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    public function editPost($postId)
    {
        $post = Post::with('images')->findOrFail($postId);
        $categories = PostCategory::get();
        return view('admin.pages.post.edit-post', compact('post', 'categories'));
    }

    /**
     * SỬA LẠI HÀM updatePost
     */
    public function updatePost(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $postId,
            'author' => 'required|string|max:255',
            'post_category_id' => 'required|exists:post_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        try {
            $postData = $request->only(['title', 'author', 'post_category_id', 'title_seo', 'description', 'content']);
            $postData['is_featured'] = $request->has('is_featured') ? 1 : 0;

            if ($request->hasFile('image')) {
                // Gọi hàm helper đã được tạo để xóa ảnh cũ
                $this->deleteImageIfExists($post->image);
                $path = $request->file('image')->store('posts', 'public');
                $postData['image'] = 'storage/' . $path;
            }

            $post->update($postData);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $galleryFile) {
                    $path = $galleryFile->store('post_gallery', 'public');
                    $post->images()->create([
                        'url' => 'storage/' . $path,
                        'caption' => pathinfo($galleryFile->getClientOriginalName(), PATHINFO_FILENAME),
                    ]);
                }
            }
            return redirect()->route('admin.post')->with('success', 'Đã cập nhật bài viết!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * SỬA LẠI HÀM deletePost
     */
    public function deletePost($postId)
    {
        $post = Post::with('images')->findOrFail($postId);
        try {
            // Xóa ảnh đại diện
            $this->deleteImageIfExists($post->image);

            // Xóa các ảnh trong thư viện
            foreach ($post->images as $image) {
                $this->deleteImageIfExists($image->url);
            }

            // Xóa bài viết và các record ảnh liên quan (nhờ `ON DELETE CASCADE`)
            $post->delete();

            return redirect()->back()->with('success', 'Đã xóa bài viết và các ảnh liên quan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa bài viết.');
        }
    }

    /**
     * THÊM HÀM HELPER ĐỂ XÓA ẢNH
     */
    private function deleteImageIfExists($path)
    {
        if ($path) {
            $correctPath = Str::replaceFirst('storage/', '', $path);
            Storage::disk('public')->delete($correctPath);
        }
    }
}
