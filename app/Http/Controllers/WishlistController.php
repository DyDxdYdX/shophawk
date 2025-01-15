<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'shop_link' => 'nullable|url|max:255',
        ]);

        auth()->user()->wishlists()->create($validated);

        return back();
    }

    public function toggleComplete(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $wishlist->update(['completed' => !$wishlist->completed]);
        return redirect()->back();
    }

    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $wishlist->delete();
        return redirect()->back()->with('success', 'Item removed from wishlist.');
    }

    public function update(Request $request, Wishlist $wishlist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'shop_link' => 'required|url'
        ]);

        $wishlist->update($validated);

        return redirect()->back();
    }
} 