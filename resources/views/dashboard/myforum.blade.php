<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-semibold mb-6">Your Forum Posts</h2>
        <div class="space-y-4">
            @forelse(auth()->user()->posts()->latest()->get() as $post)
                <div class="bg-white border rounded-lg hover:border-gray-400 transition p-4">
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span>Posted {{ $post->created_at->diffForHumans() }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $post->threads->count() }} {{ Str::plural('reply', $post->threads->count()) }}</span>
                    </div>
                    <h3 class="text-lg font-semibold">
                        <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <div class="mt-3 flex items-center space-x-3">
                        <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">You haven't created any forum posts yet.</p>
            @endforelse
        </div>
    </div>
</div> 