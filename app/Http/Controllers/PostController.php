<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        // Fetch posts ordered by newest first
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|url',
            'category' => 'required|max:255',
            'tags' => 'nullable',
        ]);

        $tags = $request->input('tags') ? json_encode(explode(',', $request->input('tags'))) : null;

        Post::create([
            'title' => $validatedData['title'],
            'excerpt' => $validatedData['excerpt'],
            'content' => $validatedData['content'],
            'image' => $validatedData['image'],
            'category' => $validatedData['category'],
            'tags' => $tags,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|url',
            'category' => 'required|max:255',
            'tags' => 'nullable',
        ]);

        $tags = $request->input('tags') ? json_encode(explode(',', $request->input('tags'))) : null;

        $post->update([
            'title' => $validatedData['title'],
            'excerpt' => $validatedData['excerpt'],
            'content' => $validatedData['content'],
            'image' => $validatedData['image'],
            'category' => $validatedData['category'],
            'tags' => $tags,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
