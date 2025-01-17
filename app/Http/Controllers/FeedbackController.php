<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Response;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = auth()->user()->is_admin
            ? Feedback::orderBy('created_at', 'desc')->get()
            : Feedback::where('email', auth()->user()->email)
                     ->orderBy('created_at', 'desc')
                     ->get();
                     
        return view('about', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'feedback' => 'required|string|max:1000',
            'category' => 'required|string|in:general,bug,feature,improvement',
        ]);

        Feedback::create([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'feedback' => $validated['feedback'],
            'category' => $validated['category']
        ]);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }

    public function update(Request $request, Feedback $feedback)
    {
        // Prevent admin from editing feedback and check if feedback belongs to user
        if (auth()->user()->is_admin || $feedback->email !== auth()->user()->email) {
            abort(403);
        }

        $validated = $request->validate([
            'feedback' => 'required|string|max:1000',
            'category' => 'required|string|in:general,bug,feature,improvement',
        ]);

        $feedback->update($validated);

        return redirect()->back()->with('success', 'Feedback updated successfully!');
    }

    public function destroy(Feedback $feedback)
    {
        // Prevent admin from deleting feedback and check if feedback belongs to user
        if (auth()->user()->is_admin || $feedback->email !== auth()->user()->email) {
            abort(403);
        }

        $feedback->delete();

        return redirect()->back()->with('success', 'Feedback deleted successfully!');
    }

    public function export()
    {
        // Check if user is admin
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
        
        // Create CSV content
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="feedback_report.csv"',
        ];
        
        $callback = function() use ($feedbacks) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['ID', 'Name', 'Email', 'Category', 'Feedback', 'Submitted At']);
            
            // Add data rows
            foreach ($feedbacks as $feedback) {
                fputcsv($file, [
                    $feedback->id,
                    $feedback->name,
                    $feedback->email,
                    $feedback->category,
                    $feedback->feedback,
                    $feedback->created_at
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
} 