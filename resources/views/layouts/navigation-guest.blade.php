<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- Logo and Navigation Links -->
            <div class="flex flex-1 items-center justify-between">
                <div class="flex items-center">
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <a href="{{ route('home') }}" 
                               class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                Home
                            </a>
                            <a href="{{ route('forum') }}" 
                               class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('forum') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                Forum
                            </a>
                            <a href="{{ route('about') }}" 
                               class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('about') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                About
                            </a>
                            <a href="{{ route('contact') }}" 
                               class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('contact') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                Contact
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Login/Register Links -->
                <div class="flex space-x-4">
                    <a href="{{ route('login') }}" 
                       class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('login') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('register') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            Register
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav> 