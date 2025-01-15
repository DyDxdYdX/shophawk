<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold mb-2">{{ $news->title }}</h1>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Published on {{ $news->published_at->format('F j, Y') }}
                        </div>
                    </div>

                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    <div class="mt-6">
                        <a href="{{ url('/') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                            ← Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 