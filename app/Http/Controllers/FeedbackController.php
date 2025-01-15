<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::where('email', auth()->user()->email)
                            ->orderBy('created_at', 'desc')
                            ->get();
        return view('about', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'feedback' => $validated['feedback']
        ]);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }

    public function update(Request $request, Feedback $feedback)
    {
        // Check if the feedback belongs to the authenticated user
        if ($feedback->email !== auth()->user()->email) {
            abort(403);
        }

        $validated = $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        $feedback->update($validated);

        return redirect()->back()->with('success', 'Feedback updated successfully!');
    }

    public function destroy(Feedback $feedback)
    {
        // Check if the feedback belongs to the authenticated user
        if ($feedback->email !== auth()->user()->email) {
            abort(403);
        }

        $feedback->delete();

        return redirect()->back()->with('success', 'Feedback deleted successfully!');
    }
} 