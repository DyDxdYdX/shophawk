<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search Bar -->
        <div class="mb-8">
            <div class="max-w-3xl mx-auto">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search for products</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="fa fa-search text-gray-500 sm:text-sm"></span>
                    </div>
                    <input type="text" 
                           name="keyword" 
                           id="keyword" 
                           value="{{ $keyword }}"
                           class="block w-full rounded-md border-0 py-3 pl-10 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6" 
                           placeholder="Search product, eg: shoes, shirts, etc.">
                    <div class="absolute inset-y-0 right-0 flex items-center">
                        <button onclick="goToSearch()" 
                                type="button" 
                                class="rounded-r-md bg-indigo-600 px-4 h-full text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shopee Results Section -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-bold text-gray-900">From Shopee.com.my</h2>
                        <img src="{{ asset('images/shopee-logo.png') }}" alt="Shopee" class="h-6 object-contain">
                    </div>
                </div>
                <a href="https://shopee.com.my/search?keyword={{ urlencode($keyword) }}" 
                   target="_blank"
                   class="text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    See more on Shopee
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            @if(empty($shopeeProducts))
                <div class="text-center py-8">
                    <p class="text-gray-500">No products found on Shopee for "{{ $keyword }}"</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($shopeeProducts as $product)
                        <a href="{{ $product['item_url'] }}" 
                           target="_blank" 
                           class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow duration-300 block">
                            <img src="{{ $product['image'] }}" 
                                 alt="{{ $product['title'] }}" 
                                 class="w-full h-32 object-cover">
                            
                            <div class="p-3">
                                <h3 class="text-sm font-medium text-gray-900 line-clamp-2 mb-1">
                                    {{ $product['title'] }}
                                </h3>
                                
                                <div class="flex items-baseline gap-2">
                                    <span class="text-base font-bold text-red-600">
                                        RM{{ $product['price'] }}
                                    </span>
                                    @if($product['discount'] > 0)
                                        <span class="text-xs text-red-600 font-medium">
                                            -{{ $product['discount'] }}%
                                        </span>
                                    @endif
                                </div>
                                
                                @if($product['brand'])
                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ $product['brand'] }}
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Lazada Results Section -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-bold text-gray-900">From Lazada.com.my</h2>
                        <img src="{{ asset('images/lazada-logo.png') }}" alt="Lazada" class="h-6 object-contain">
                    </div>
                </div>
                <a href="https://www.lazada.com.my/catalog/?q={{ urlencode($keyword) }}" 
                   target="_blank"
                   class="text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    See more on Lazada
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            @if(empty($lazadaProducts))
                <div class="text-center py-8">
                    <p class="text-gray-500">No products found on Lazada for "{{ $keyword }}"</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($lazadaProducts as $product)
                        <a href="{{ $product['item_url'] }}" 
                           target="_blank" 
                           class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow duration-300 block">
                            <img src="{{ $product['image'] }}" 
                                 alt="{{ $product['title'] }}" 
                                 class="w-full h-32 object-cover">
                            
                            <div class="p-3">
                                <h3 class="text-sm font-medium text-gray-900 line-clamp-2 mb-1">
                                    {{ $product['title'] }}
                                </h3>
                                
                                <div class="flex items-baseline gap-2">
                                    <span class="text-base font-bold text-red-600">
                                        RM{{ $product['price'] }}
                                    </span>
                                    @if($product['discount'] > 0)
                                        <span class="text-xs text-red-600 font-medium">
                                            -{{ $product['discount'] }}%
                                        </span>
                                    @endif
                                </div>
                                
                                @if($product['brand'])
                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ $product['brand'] }}
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function goToSearch() {
            const keyword = document.getElementById('keyword').value;
            if (keyword.trim()) {
                window.location.href = `/search-products?keyword=${encodeURIComponent(keyword)}`;
            }
        }

        // Also allow Enter key to trigger search
        document.getElementById('keyword').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                goToSearch();
            }
        });
    </script>
    @endpush
</x-app-layout> 