<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'forum');
        $type = $request->query('type', 'threads');
        
        if ($tab === 'forum' && $type === 'threads') {
            $threads = \DB::table('threads')
                ->join('posts', 'threads.post_id', '=', 'posts.id')
                ->select('threads.*', 'posts.title as post_title')
                ->where('threads.user_id', auth()->id())
                ->orderBy('threads.created_at', 'desc')
                ->get();

            \Log::info('Threads found: ' . $threads->count());
            
            return view('dashboard', compact('threads'));
        }
        
        return view('dashboard', ['threads' => collect()]);
    }
} 