<nav x-data="{ open: false }" class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- Mobile menu button -->
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <button @click="open = ! open" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" :class="{'hidden': open, 'block': ! open }" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" :class="{'hidden': ! open, 'block': open }" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Logo and Navigation Links -->
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')" 
                            class="rounded-md px-3 py-2 text-sm font-medium" 
                            :class="request()->routeIs('home') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                            {{ __('Home') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                            class="rounded-md px-3 py-2 text-sm font-medium" 
                            :class="request()->routeIs('dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('forum')" :active="request()->routeIs('forum') || request()->routeIs('posts.show')"
                            class="rounded-md px-3 py-2 text-sm font-medium" 
                            :class="request()->routeIs('forum') || request()->routeIs('posts.show') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                            {{ __('Forum') }}
                        </x-nav-link>

                        <x-nav-link :href="route('about')" :active="request()->routeIs('about')" 
                            class="rounded-md px-3 py-2 text-sm font-medium" 
                            :class="request()->routeIs('about') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                            {{ __('About') }}
                        </x-nav-link>

                        <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')" 
                            class="rounded-md px-3 py-2 text-sm font-medium" 
                            :class="request()->routeIs('contact') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                            {{ __('Contact') }}
                        </x-nav-link>

                        @if (Auth::user()->is_admin)
                            <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" 
                                class="rounded-md px-3 py-2 text-sm font-medium" 
                                :class="request()->routeIs('products.*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                                {{ __('Products') }}
                            </x-nav-link>

                            <x-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')" 
                                class="rounded-md px-3 py-2 text-sm font-medium" 
                                :class="request()->routeIs('news.*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                                {{ __('News') }}
                            </x-nav-link>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

                <div class="relative ml-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                <div class="text-white px-3 py-2">{{ Auth::user()->name }}</div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="block px-4 py-2 text-sm text-gray-700">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="block px-4 py-2 text-sm text-gray-700">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
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

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="block rounded-md px-3 py-2 text-base font-medium"
                :class="request()->routeIs('dashboard') ? 'bg-gray-900 text-black' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('forum')" :active="request()->routeIs('forum') || request()->routeIs('posts.show')"
                class="block rounded-md px-3 py-2 text-base font-medium"
                :class="request()->routeIs('forum') || request()->routeIs('posts.show') ? 'bg-gray-900 text-black' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                {{ __('Forum') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')"
                class="block rounded-md px-3 py-2 text-base font-medium"
                :class="request()->routeIs('about') ? 'bg-gray-900 text-black' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                {{ __('About') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')"
                class="block rounded-md px-3 py-2 text-base font-medium"
                :class="request()->routeIs('contact') ? 'bg-gray-900 text-black' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                {{ __('Contact') }}
            </x-responsive-nav-link>

            @if (Auth::user()->is_admin)
                <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')"
                    class="block rounded-md px-3 py-2 text-base font-medium"
                    :class="request()->routeIs('products.*') ? 'bg-gray-900 text-black' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                    {{ __('Products') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')"
                    class="block rounded-md px-3 py-2 text-base font-medium"
                    :class="request()->routeIs('news.*') ? 'bg-gray-900 text-black' : 'text-gray-300 hover:bg-gray-700 hover:text-white'">
                    {{ __('News') }}
                </x-responsive-nav-link>
            @endif
        </div>
    </div>
</nav>
