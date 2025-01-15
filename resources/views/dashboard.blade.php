<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation Tabs -->
            <div class="mb-8 border-b border-gray-200">
                <nav class="flex space-x-8" x-data="{ active: '{{ request()->query('tab', 'forum') }}' }">
                    <a href="{{ route('dashboard', ['tab' => 'forum']) }}"
                       class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap"
                       :class="active === 'forum' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    >
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                        Forum Posts
                    </a>

                    <a href="{{ route('dashboard', ['tab' => 'wishlist']) }}"
                       class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap"
                       :class="active === 'wishlist' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    >
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                        Wishlist
                    </a>

                    <a href="{{ route('dashboard', ['tab' => 'budget']) }}"
                       class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap"
                       :class="active === 'budget' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    >
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Budget
                    </a>
                </nav>
            </div>

            <!-- Content Section -->
            @if(request()->query('tab', 'forum') === 'forum')
                @include('dashboard.myforum')
            @elseif(request()->query('tab') === 'wishlist')
                @include('dashboard.wishlist')
            @elseif(request()->query('tab') === 'budget')
                @include('dashboard.budget')
            @endif
        </div>
    </div>
</x-app-layout> 