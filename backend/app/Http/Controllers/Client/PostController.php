<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Lấy danh sách tất cả bài viết.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    public function show(Post $post)
    {
        // Eager load các ảnh liên quan
        return response()->json($post->load('images'));
    }
}
