<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    // =================================================================
    // QUẢN LÝ DANH MỤC BÀI VIẾT
    // =================================================================
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
        $validated['status'] = $request->has('status');

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
        $validated['status'] = $request->has('status');

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
    // QUẢN LÝ BÀI VIẾT
    // =================================================================
    public function post(Request $request)
    {
        $query = Post::with('category');

        if ($request->filled('post_category_id')) {
            $query->where('post_category_id', $request->post_category_id);
        }
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $perPage = (int) $request->input('per_page', 10);
        // Sắp xếp theo cột 'order'
        $posts = $query->orderBy('order', 'asc')->paginate($perPage)->appends($request->all());
        $categories = PostCategory::orderBy('name')->get();

        return view('admin.pages.post.list-post', compact('posts', 'categories'));
    }

    public function changeStatusPost(Request $request)
    {
        try {
            $post = Post::findOrFail($request->id);
            $type = $request->type;

            if (in_array($type, ['status', 'is_featured'])) {
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
        $categories = PostCategory::where('status', 1)->orderBy('name')->get();
        return view('admin.pages.post.add-post', compact('categories'));
    }

    public function storePost(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'author' => 'nullable|string|max:255',
            'post_category_id' => 'required|exists:post_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'title_seo' => 'nullable|string|max:255',
            'content' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'status' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        try {
            $postData = $validatedData;

            $postData['status'] = $request->has('status');
            $postData['is_featured'] = $request->has('is_featured');

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('news_upload', 'public');
                $postData['image'] = 'storage/' . $path;
            }

            $post = Post::create($postData);
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $file) {
                    $path = $file->store('post_gallery', 'public');
                    // Dùng relationship 'images()' đã tạo trong Model Post để tạo record
                    $post->images()->create([
                        'url' => 'storage/' . $path,
                        'order' => $key + 1, // Gán thứ tự cho ảnh
                    ]);
                }
            }
            return redirect()->route('admin.post')->with('success', 'Tạo bài viết thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    public function editPost(Post $post)
    {
        $categories = PostCategory::orderBy('name')->get();
        return view('admin.pages.post.edit-post', compact('post', 'categories'));
    }

    public function updatePost(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $post->id,
            'author' => 'nullable|string|max:255',
            'post_category_id' => 'required|exists:post_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'title_seo' => 'nullable|string|max:255',
            'content' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'status' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        try {
            $postData = $validatedData;

            $postData['status'] = $request->has('status');
            $postData['is_featured'] = $request->has('is_featured');

            if ($request->input('delete_image') == '1') {
                $this->deleteImageIfExists($post->image);
                $postData['image'] = null;
            }

            if ($request->hasFile('image')) {
                $this->deleteImageIfExists($post->image);
                $path = $request->file('image')->store('posts', 'public');
                $postData['image'] = 'storage/' . $path;
            }

            $post->update($postData);

            return redirect()->route('admin.post')->with('success', 'Đã cập nhật bài viết!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    public function deletePost(Post $post)
    {
        try {
            $this->deleteImageIfExists($post->image);
            $post->delete();
            return redirect()->back()->with('success', 'Đã xóa bài viết!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa bài viết.');
        }
    }

    /**
     * Helper function to delete an image if it exists.
     *
     * @param string|null $path
     */
    private function deleteImageIfExists($path)
    {
        if ($path) {
            $correctPath = Str::replaceFirst('storage/', '', $path);
            if (Storage::disk('public')->exists($correctPath)) {
                Storage::disk('public')->delete($correctPath);
            }
        }
    }
}
