<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-semibold mb-6">Wishlist</h2>
        <!-- Add Wishlist Button -->
        <div class="mb-6">
            <form action="{{ route('wishlist.store') }}" method="POST" class="flex gap-4">
                @csrf
                <div class="flex-1 space-y-2">
                    <input type="text" 
                           name="name" 
                           placeholder="Item name"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                           required>
                    <input type="url" 
                           name="shop_link" 
                           placeholder="Shop link (optional)"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 h-fit self-end">
                    Add Item
                </button>
            </form>
        </div>

        <!-- Display Wishlist Items -->
        <div class="space-y-4">
            @forelse(auth()->user()->wishlists()->latest()->get() as $item)
                <div class="bg-white p-4 rounded-lg border {{ $item->completed ? 'bg-gray-50' : '' }}">
                    <div x-data="{ editing: false, link: '{{ $item->shop_link }}', name: '{{ $item->name }}' }">
                        <!-- View Mode -->
                        <div x-show="!editing" class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 min-w-0 flex-1">
                                <form action="{{ route('wishlist.toggle', $item) }}" method="POST" class="flex-shrink-0">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="flex items-center">
                                        <div class="w-6 h-6 border-2 rounded {{ $item->completed ? 'bg-blue-500 border-blue-500' : 'border-gray-300' }} flex items-center justify-center">
                                            @if($item->completed)
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </button>
                                </form>
                                
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-col">
                                        <span class="text-lg font-medium {{ $item->completed ? 'line-through text-gray-500' : '' }}">
                                            {{ $item->name }}
                                        </span>
                                        <a :href="link" 
                                           target="_blank" 
                                           class="text-blue-600 hover:text-blue-800 block truncate text-sm {{ $item->completed ? 'line-through text-gray-500' : '' }}"
                                           title="{{ $item->shop_link }}">
                                            {{ $item->shop_link }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 flex-shrink-0 ml-4">
                                <span class="text-sm text-gray-500 whitespace-nowrap">
                                    {{ $item->created_at->diffForHumans() }}
                                </span>
                                <button @click="editing = true" class="text-gray-500 hover:text-gray-700 p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('wishlist.destroy', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Edit Mode -->
                        <div x-show="editing" @click.away="editing = false" class="mt-2">
                            <form action="{{ route('wishlist.update', $item) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label for="name_{{ $item->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        Item Name
                                    </label>
                                    <input type="text" 
                                           id="name_{{ $item->id }}"
                                           name="name" 
                                           :value="name"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-base py-2"
                                           required>
                                </div>
                                <div>
                                    <label for="shop_link_{{ $item->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        Shop Link
                                    </label>
                                    <input type="url" 
                                           id="shop_link_{{ $item->id }}"
                                           name="shop_link" 
                                           :value="link"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-base py-2"
                                           required>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Save Changes
                                    </button>
                                    <button type="button" 
                                            @click="editing = false"
                                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Your wishlist is empty.</p>
            @endforelse
        </div>
    </div>
</div> 