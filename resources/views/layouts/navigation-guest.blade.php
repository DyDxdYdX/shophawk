<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- Logo and Navigation Links -->
            <div class="flex flex-1 items-center justify-between">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('images/Shophawk no text.png') }}" alt="ShopHawk Logo" class="h-8 w-auto rounded-full">
                    </a>
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
            <x-nav-link :href="route('home')" :active="request()->routeIs('home')" 
                                class="rounded-md px-3 py-2 text-sm font-medium" 
                                :class="request()->routeIs('home') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                                {{ __('Home') }}
                            </x-nav-link>
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

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')"
                class="block rounded-md px-3 py-2 text-base font-medium"
                :class="request()->routeIs('home') ? 'bg-gray-900 text-black' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                {{ __('Home') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav> 