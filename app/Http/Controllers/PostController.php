<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user.profile', 'likes', 'comments.user'])
                    ->latest()
                    ->paginate(10);
                    
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $request->user()->posts()->create($validated);

        return back()->with('status', 'Post created!');
    }

    public function destroy(Post $post)
    {
        abort_if($post->user_id !== Auth::id(), 403);
        
        $post->delete();

        return back()->with('status', 'Post deleted!');
    }

    public function toggleLike(Post $post)
    {
        $like = $post->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        } else {
            $post->likes()->create(['user_id' => Auth::id()]);
        }

        return back();
    }
}
