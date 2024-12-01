<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blog()
{
    $posts = Post::orderBy('created_at', 'desc')->get();

    return view('client.pages.blog', compact('posts'));
}
public function show($id)
{
    // Lấy bài viết theo ID mà không lấy comments
    $post = Post::findOrFail($id);

    // Lấy 5 bài viết gần đây
    $recentPosts = Post::where('id', '!=', $id)
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

    return view('client.pages.blog-detail', compact('post', 'recentPosts'));
}
}
