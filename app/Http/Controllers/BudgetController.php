<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        return view('dashboard.budget');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'limit' => 'required|numeric|min:0',
        ]);

        auth()->user()->budgets()->create($validated);

        return back()->with('success', 'Budget created successfully');
    }

    public function update(Request $request, Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'limit' => 'required|numeric|min:0',
        ]);

        $budget->update($validated);

        return back()->with('success', 'Budget updated successfully');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) {
            abort(403);
        }

        $budget->delete();
        return back()->with('success', 'Budget category deleted successfully');
    }

    public function addExpense(Request $request, Budget $budget)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $budget->spent += $request->amount;
        $budget->save();

        return back()->with('success', 'Expense added successfully');
    }
}
