<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Shophawk</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <!-- Background Image with Overlay (Adjusted z-index) -->
        <div class="fixed inset-0 z-0">
            <img src="{{ asset('images/shopping-bg.jpg') }}" alt="Background" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-white/90 dark:bg-black/90"></div>
        </div>

        <div class="min-h-screen relative z-10">
            @auth
                @include('layouts.navigation')
            @else
                @include('layouts.navigation-guest')
            @endauth

            <!-- Chat Button Circle -->
            @auth
                <div class="fixed bottom-8 right-8 z-50">
                    <a href="{{ route('chat') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition-all duration-200 hover:scale-110"
                    >
                        <i class="fas fa-comments text-xl"></i>
                        
                        <!-- Online Status Indicator -->
                        <span class="absolute top-0 right-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </a>
                </div>
            @endauth

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/50 dark:bg-gray-800/50 shadow backdrop-blur-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                Shophawk Guru - Dexter D. Timothy
                <br>
                Final Year Project Development
            </footer>
        </div>

        @auth
        <script>
            // Prevent back button after logout
            window.onload = function() {
                if(window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
            }
            
            // Force reload on back/forward
            window.addEventListener('pageshow', function(event) {
                if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                    window.location.reload(true);
                }
            });

            // Handle logout
            document.addEventListener('DOMContentLoaded', function() {
                let logoutForms = document.querySelectorAll('form[action$="logout"]');
                logoutForms.forEach(function(form) {
                    form.addEventListener('submit', function() {
                        // Clear all storage
                        localStorage.clear();
                        sessionStorage.clear();
                        
                        // Clear all cookies
                        document.cookie.split(";").forEach(function(c) { 
                            document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); 
                        });
                    });
                });
            });
        </script>
        @endauth
    </body>
</html>
