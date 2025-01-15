<x-app-layout>
    <div class="text-black/50 dark:text-white/50">
        <!-- Hero Section -->
        <div class="relative min-h-[60vh] flex flex-col items-center justify-center selection:bg-indigo-600 selection:text-white">
            <!-- Content -->
            <div class="relative z-10 w-full max-w-2xl px-6 lg:max-w-7xl text-center">
                <h1 class="text-5xl font-bold mb-4 text-black dark:text-white">Shophawk Guru</h1>
                <p class="text-xl mb-8 text-gray-600 dark:text-gray-300">Your Smart Shopping Companion for Price Comparison</p>
                
                <!-- Search Section -->
                <div class="max-w-2xl mx-auto bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm p-6 rounded-lg shadow-lg">
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="fa fa-search text-gray-500 sm:text-sm"></span>
                        </div>
                        <input type="text" name="keyword" id="keyword" 
                            class="block w-full rounded-md border-0 py-3 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6" 
                            placeholder="Search product, eg: shoes, shirts, etc.">
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <button onclick="goToSearch()" 
                                type="button" 
                                class="rounded-r-md bg-indigo-600 px-6 py-3 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                Search
                            </button>
                        </div>
                    </div>
                    
                    <!-- Source filters -->
                    <div class="flex gap-4 justify-center mt-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" id="shopee" class="form-checkbox h-4 w-4 text-indigo-600" checked>
                            <span class="ml-2 text-gray-700 dark:text-gray-300">Shopee</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" id="lazada" class="form-checkbox h-4 w-4 text-indigo-600" checked>
                            <span class="ml-2 text-gray-700 dark:text-gray-300">Lazada</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" id="local" class="form-checkbox h-4 w-4 text-indigo-600" checked>
                            <span class="ml-2 text-gray-700 dark:text-gray-300">Other</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-12 text-black dark:text-white">Why use Shophawk Guru?</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Price Comparison -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="text-indigo-600 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-black dark:text-white">Price Comparison</h3>
                        <p class="text-gray-600 dark:text-gray-300">Compare prices across multiple platforms to find the best deals available.</p>
                    </div>

                    <!-- Community Forum -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="text-indigo-600 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-black dark:text-white">Community Forum</h3>
                        <p class="text-gray-600 dark:text-gray-300">Join discussions, share experiences, and get recommendations from other shoppers.</p>
                    </div>

                    <!-- Budget Tracking -->
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="text-indigo-600 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-black dark:text-white">Wishlist & Budget</h3>
                        <p class="text-gray-600 dark:text-gray-300">Track your desired items and manage your shopping budget effectively.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- News Section -->
        <div class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-8 text-black dark:text-white">Latest News</h2>
                
                @php
                    $news = \App\Models\News::where('status', 'published')
                        ->orderBy('published_at', 'desc')
                        ->take(3)
                        ->get();
                @endphp
                
                @if($news->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($news as $article)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-xl font-semibold text-black dark:text-white">
                                            {{ $article->title }}
                                        </h3>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                        {{ Str::limit(strip_tags($article->content), 150) }}
                                    </p>
                                    <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                        <span>{{ $article->published_at?->format('M d, Y') }}</span>
                                        <a href="{{ route('news.show', $article) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Read more →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-600 dark:text-gray-400">No news articles available at the moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function goToSearch() {
            const keyword = document.getElementById('keyword').value;
            if (keyword.trim()) {
                const isAuthenticated = {!! auth()->check() ? 'true' : 'false' !!};
                const shopee = document.getElementById('shopee').checked;
                const lazada = document.getElementById('lazada').checked;
                const local = document.getElementById('local').checked;
                
                if (!shopee && !lazada && !local) {
                    alert('Please select at least one source to search from');
                    return;
                }

                const searchParams = new URLSearchParams({
                    keyword: keyword,
                    shopee: shopee,
                    lazada: lazada,
                    local: local
                });

                window.location.href = isAuthenticated 
                    ? `/search-products?${searchParams.toString()}`
                    : '/login';
            } else {
                alert('Please enter a search keyword');
            }
        }

        // Also allow Enter key to trigger search
        document.getElementById('keyword').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                goToSearch();
            }
        });

        // Add this to prevent browser back button after logout
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</x-app-layout>
