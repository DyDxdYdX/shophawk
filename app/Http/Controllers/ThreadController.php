<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use App\Notifications\ThreadDeletedNotification;
use App\Notifications\NewThreadNotification;

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

        // Notify the post owner if it's not their own thread
        $post = $thread->post;
        if ($post->user_id !== auth()->id()) {
            $post->user->notify(new NewThreadNotification($thread, auth()->user()));
        }

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

    public function destroy(Request $request, Thread $thread)
    {
        // Check if user is authorized to delete this thread
        if ($thread->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        // If an admin is deleting someone else's thread, require and validate reason
        if (auth()->user()->is_admin && auth()->id() !== $thread->user_id) {
            $validated = $request->validate([
                'reason' => 'required|string|max:255'
            ]);
            
            $thread->user->notify(new ThreadDeletedNotification(
                $thread,
                auth()->user(),
                $validated['reason']
            ));
        }

        $thread->delete();

        return redirect()->back();
    }
}
