<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-semibold mb-6">Budget Tracker</h2>
        
        <!-- Budget Summary -->
        @php
            $budgets = auth()->user()->budgets()->latest()->get();
            $totalBudget = $budgets->sum('limit');
            $totalSpent = $budgets->sum('spent');
            $totalRemaining = $totalBudget - $totalSpent;
        @endphp
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="text-sm text-blue-600 mb-1">Total Budget</div>
                <div class="text-2xl font-bold text-blue-700">
                    RM{{ number_format($totalBudget, 2) }}
                </div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="text-sm text-green-600 mb-1">Total Spent</div>
                <div class="text-2xl font-bold text-green-700">
                    RM{{ number_format($totalSpent, 2) }}
                </div>
            </div>
            <div class="bg-{{ $totalRemaining < 0 ? 'red' : 'gray' }}-50 p-4 rounded-lg">
                <div class="text-sm text-{{ $totalRemaining < 0 ? 'red' : 'gray' }}-600 mb-1">Total Remaining</div>
                <div class="text-2xl font-bold text-{{ $totalRemaining < 0 ? 'red' : 'gray' }}-700">
                    RM{{ number_format($totalRemaining, 2) }}
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add Budget Form -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('budgets.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="category" :value="__('Budget Category')" />
                            <x-text-input id="category" name="category" type="text" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="limit" :value="__('Monthly Limit')" />
                            <x-text-input id="limit" name="limit" type="number" step="0.01" class="mt-1 block w-full" required />
                        </div>
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                {{ __('Add Budget') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Display Budgets -->
        <div class="space-y-4">
            @forelse(auth()->user()->budgets()->latest()->get() as $budget)
                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    <div class="flex flex-col space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex flex-col">
                                    <span class="text-lg font-medium">
                                        {{ $budget->category }}
                                    </span>
                                    <div class="flex space-x-4 text-sm">
                                        <span class="text-blue-600">
                                            Budget: RM{{ number_format($budget->limit, 2) }}
                                        </span>
                                        <span class="text-{{ $budget->spent > $budget->limit ? 'red' : 'green' }}-600">
                                            Spent: RM{{ number_format($budget->spent, 2) }}
                                        </span>
                                        <span class="text-gray-600">
                                            Remaining: RM{{ number_format($budget->limit - $budget->spent, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-500 whitespace-nowrap">
                                    {{ $budget->created_at->diffForHumans() }}
                                </span>
                                <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 p-1"
                                            onclick="return confirm('Are you sure you want to delete this budget?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Add Expense Form -->
                        <form action="{{ route('budgets.add-expense', $budget) }}" method="POST" class="mt-2">
                            @csrf
                            <div class="flex space-x-4">
                                <div class="flex-1">
                                    <x-input-label for="amount_{{ $budget->id }}" :value="__('Add Expense')" class="sr-only" />
                                    <x-text-input id="amount_{{ $budget->id }}" 
                                                 name="amount" 
                                                 type="number" 
                                                 step="0.01" 
                                                 class="mt-1 block w-full" 
                                                 placeholder="Enter amount" 
                                                 required />
                                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                </div>
                                <button type="submit" 
                                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    {{ __('Add Expense') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    <p class="text-gray-500 text-center">No budgets set yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div> 