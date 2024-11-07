<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id'
        ]);

        $thread = Thread::create([
            'content' => $validated['content'],
            'post_id' => $validated['post_id'],
            'user_id' => auth()->id()
        ]);

        return back()->with('success', 'Thread posted successfully!');
    }

    public function destroy(Thread $thread)
    {
        if ($thread->user_id !== auth()->id()) {
            abort(403);
        }

        $thread->delete();
        return back()->with('success', 'Thread deleted successfully!');
    }
}
