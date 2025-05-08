<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::when(!auth()->user()?->is_admin, function ($query) {
            $query->where('status', 'published');
        })->orderBy('created_at', 'desc')->paginate(10);

        Log::info('News Index Query', [
            'current_time' => now()->toDateTimeString(),
            'articles' => $news->map(function($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'status' => $article->status,
                    'published_at' => $article->published_at
                ];
            })->toArray()
        ]);

        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published'
        ]);

        News::create($validated);

        return redirect()->route('news.index')
            ->with('success', 'News article created successfully.');
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published'
        ]);

        $news->update($validated);

        return redirect()->route('news.index')
            ->with('success', 'News article updated successfully.');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('news.index')
            ->with('success', 'News article deleted successfully.');
    }

    public function show(News $news)
    {
        if (!auth()->user()?->is_admin) {
            abort_unless($news->status === 'published', 403);
        }
        
        return view('news.show', compact('news'));
    }
} 