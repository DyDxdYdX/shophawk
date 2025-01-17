<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\PostDeletedNotification;

class PostController extends Controller
{
    use AuthorizesRequests;

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
            ->paginate(5)
            ->appends(['search' => $search, 'filter' => $filter]);
        
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

    public function edit(Post $post)
    {
        // Check if user is authorized to edit this post
        $this->authorize('update', $post);
        
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Check if user is authorized to update this post
        $this->authorize('update', $post);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if (auth()->user()->is_admin) {
            $reason = request('reason') ?? 'No reason provided';
            $post->user->notify(new PostDeletedNotification($post, auth()->user(), $reason));
            $post->delete();
            
            return redirect()->route('posts.index')
                ->with('success', 'Post has been deleted successfully.');
        }

        // Handle non-admin delete logic...
    }
} 