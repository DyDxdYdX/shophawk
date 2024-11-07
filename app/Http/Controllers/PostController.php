<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'hot');
        $search = $request->get('search');
        
        $posts = Post::with(['threads', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->when($filter === 'hot', function ($query) {
                return $query->withCount('threads')
                            ->orderByDesc('threads_count');
            })
            ->when($filter === 'new', function ($query) {
                return $query->latest();
            })
            ->paginate(15)
            ->withQueryString(); // This preserves both filter and search parameters in pagination
        
        return view('forum', compact('posts', 'filter'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = $request->user()->posts()->create($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function vote(Request $request, Post $post)
    {
        $validated = $request->validate([
            'vote' => 'required|in:up,down',
        ]);

        // Simple voting system - you might want to create a separate votes table
        // for a more sophisticated system that prevents multiple votes
        $value = $validated['vote'] === 'up' ? 1 : -1;
        $post->increment('votes', $value);

        return response()->json([
            'votes' => $post->votes,
        ]);
    }
} 