<!DOCTYPE html>
<html class="h-full bg-white" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Shophawk</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])   
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
    </head>
    <body>
        @auth
            @include('layouts.navigation')
        @else
            @include('layouts.navigation-guest')
        @endauth

        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <img id="background" class="absolute -left-20 top-0 max-w-[877px]"/>
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <main class="mt-6">
                        <div>
                            <label for="price" class="block text-sm/7 font-medium text-gray-900"></label>
                            <div class="relative mt-2 rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="fa fa-search text-gray-500 sm:text-sm"></span>
                                </div>
                                <input type="text" name="keyword" id="keyword" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6" placeholder=" Search product, eg: shoes, shirts, etc.">
                                <div class="absolute inset-y-0 right-0 flex items-center">
                                <button onclick="goToSearch()" 
                                        type="button" 
                                        class="rounded-r-md bg-indigo-600 px-4 py-1.5 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </div>

                    </main>
                </div>
            </div>
        </div>

        <script>
            function goToSearch() {
                const keyword = document.getElementById('keyword').value;
                if (keyword.trim()) {
                    const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
                    window.location.href = isAuthenticated 
                        ? `/search-products?keyword=${encodeURIComponent(keyword)}`
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
        </script>

        <footer class="py-16 text-center text-sm text-black dark:text-white/70">
            Shophawk Guru - Dexter D. Timothy
            <br>
            Final Year Project Development
        </footer>
    </body>
</html>
