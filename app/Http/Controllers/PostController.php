<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.posts.list', compact('posts'));
    }

        public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required',
            'secondary_content' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'secondary_image' => 'nullable|image|max:2048',
         
        ]);
        $validated['slug'] = \Str::slug($validated['title']);
        $validated['author_id'] = auth()->id();
        $imagePath = '';
        if ($request->hasFile('thumbnail')) {
            $imageName = pathinfo($validated['thumbnail']->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $validated['thumbnail']->getClientOriginalExtension();
            $nameWithTimestamp = $imageName . '_' . time() . '.' . $extension;
    
            // public/thumbnail
            $imagePath = $request->file('thumbnail')->move(public_path('thumbnail'), $nameWithTimestamp);
            $imagePath = 'thumbnail/' . $nameWithTimestamp;
        }
    $secondaryImagePath = '';
    if ($request->hasFile('secondary_image')) {
        $subImageName = pathinfo($validated['secondary_image']->getClientOriginalName(), PATHINFO_FILENAME);
        $subExtension = $validated['secondary_image']->getClientOriginalExtension();
        $subNameWithTimestamp = $subImageName . '_' . time() . '.' . $subExtension;

        $secondaryImagePath = $request->file('secondary_image')->move(public_path('thumbnail'), $subNameWithTimestamp);
        $secondaryImagePath = 'thumbnail/' . $subNameWithTimestamp;
    }
    $validated['thumbnail'] = $imagePath;
    $validated['secondary_image'] = $secondaryImagePath;
        Post::create($validated);
        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được thêm!');
    }
    
    
    


    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required',
            'secondary_content' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'secondary_image' => 'nullable|image|max:2048',
        ]);
    
        $validated['slug'] = \Str::slug($validated['title']);
        $validated['author_id'] = auth()->id();
    
        // Lưu ảnh đại diện (thumbnail)
        $imagePath = $post->thumbnail;
        if ($request->hasFile('thumbnail')) {
            $imageName = pathinfo($validated['thumbnail']->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $validated['thumbnail']->getClientOriginalExtension();
            $nameWithTimestamp = $imageName . '_' . time() . '.' . $extension;
    
            $imagePath = $request->file('thumbnail')->move(public_path('thumbnail'), $nameWithTimestamp);
            $imagePath = 'thumbnail/' . $nameWithTimestamp;
        }
    
        // Lưu ảnh phụ (secondary_image)
        $secondaryImagePath = $post->secondary_image;
        if ($request->hasFile('secondary_image')) {
            $subImageName = pathinfo($validated['secondary_image']->getClientOriginalName(), PATHINFO_FILENAME);
            $subExtension = $validated['secondary_image']->getClientOriginalExtension();
            $subNameWithTimestamp = $subImageName . '_' . time() . '.' . $subExtension;
    
            $secondaryImagePath = $request->file('secondary_image')->move(public_path('thumbnail'), $subNameWithTimestamp);
            $secondaryImagePath = 'thumbnail/' . $subNameWithTimestamp;
        }
    
        // Cập nhật các dữ liệu vào mảng validated
        $validated['thumbnail'] = $imagePath;
        $validated['secondary_image'] = $secondaryImagePath;
    
        $post->update($validated);
    
        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được cập nhật!');
    }
    
    
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
    
        $post->delete();
    
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Bài viết đã được xóa thành công!',
            ]);
        }
    
        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được xóa!');
    }


public function deletedPosts()
{
    $deletedPosts = Post::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
    return view('admin.posts.delete', compact('deletedPosts'));
}
public function restore($id)
{
    $post = Post::withTrashed()->findOrFail($id); 
    $post->restore(); 

    return redirect()->route('admin.posts.listDelete')->with('success', 'Bài viết đã được phục hồi!');
}
public function forceDelete($id)
{
    $post = Post::withTrashed()->findOrFail($id);
    $post->forceDelete(); 

    return redirect()->route('admin.posts.listDelete')->with('success', 'Bài viết đã được xóa vĩnh viễn!');
}

    


}
