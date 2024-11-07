<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-900">← Back to Posts</a>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">{{ $post->title }}</h1>
                    <div class="flex items-center text-gray-600 text-sm mb-4">
                        <span>Posted by {{ $post->user->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="prose mb-8">
                        {{ $post->content }}
                    </div>

                    <!-- Threads Section -->
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold mb-4">Threads</h2>
                        
                        <!-- Thread Form -->
                        <form action="{{ route('threads.store') }}" method="POST" class="mb-6">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div>
                                <textarea name="content" rows="3" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Start a new thread..."></textarea>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Post Thread
                                </button>
                            </div>
                        </form>

                        <!-- Threads List -->
                        <div class="space-y-6">
                            @foreach($post->threads()->latest()->get() as $thread)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ $thread->user->name }}</span>
                                            <span class="text-gray-500 text-sm ml-2">{{ $thread->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if($thread->user_id === auth()->id())
                                            <form action="{{ route('threads.destroy', $thread) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        {{ $thread->content }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 