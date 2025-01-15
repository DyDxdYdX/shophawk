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

        return redirect()->back();
    }

    public function update(Request $request, Thread $thread)
    {
        // Check if user is authorized to update this thread
        if ($thread->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $thread->update($validated);

        return redirect()->back();
    }

    public function destroy(Thread $thread)
    {
        // Check if user is authorized to delete this thread
        if ($thread->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $thread->delete();

        return redirect()->back();
    }
}
