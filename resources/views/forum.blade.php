<x-app-layout>
    <div x-data="{ showDeleteModal: false, postToDelete: null, deleteForm: null }">
        <!-- Success Message -->
        @if (session('success'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal" 
             class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50"
             x-cloak>
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Delete Post</h3>
                <form x-ref="modalDeleteForm" method="POST" class="space-y-4">
                    @csrf
                    @method('DELETE')
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason for deletion</label>
                        <textarea name="reason" 
                              id="reason"
                              required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                @click="showDeleteModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                            Delete Post
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-2xl font-semibold mb-6">Forum</h2>
                <!-- Search Bar -->
                <div class="mb-6">
                    <form action="{{ route('posts.index') }}" method="GET" class="flex gap-2">
                        <input type="text" 
                               name="search" 
                               placeholder="Search posts..." 
                               value="{{ request('search') }}"
                               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        
                        <!-- Preserve the filter when searching -->
                        <input type="hidden" name="filter" value="{{ $filter }}">
                        
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md">
                            Search
                        </button>
                    </form>
                </div>

                <!-- Create Post Button -->
                <div class="mb-6">
                    <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Post
                    </a>
                </div>

                <!-- Filter Tabs -->
                <div class="bg-white rounded-t-lg border-b">
                    <div class="flex space-x-6 p-4">
                        <a href="{{ route('posts.index', ['filter' => 'hot']) }}" 
                           class="{{ $filter === 'hot' ? 'text-blue-600 font-medium' : 'text-gray-500 hover:text-gray-700' }}">
                            Hot
                        </a>
                        <a href="{{ route('posts.index', ['filter' => 'new']) }}" 
                           class="{{ $filter === 'new' ? 'text-blue-600 font-medium' : 'text-gray-500 hover:text-gray-700' }}">
                            New
                        </a>
                    </div>
                </div>

                <!-- Posts List -->
                <div class="space-y-4">
                    @foreach($posts as $post)
                    <div class="bg-white border rounded-lg hover:border-gray-400 transition">
                        <!-- Post Content -->
                        <div class="p-4">
                            <div class="flex items-center text-xs text-gray-500 mb-2">
                                <span>Posted by</span>
                                <a href="#" class="ml-1 hover:underline">{{ $post->user->name }}</a>
                                <span class="mx-1">•</span>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                                @if($post->user_id === auth()->id() || auth()->user()->is_admin)
                                    <span class="mx-1">•</span>
                                    @if($post->user_id === auth()->id())
                                        <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                        <span class="mx-1">•</span>
                                    @endif
                                    
                                    @if(auth()->user()->is_admin && auth()->id() !== $post->user_id)
                                        <!-- Admin delete button -->
                                        <button type="button" 
                                                @click="showDeleteModal = true; 
                                                        $refs.modalDeleteForm.action = '{{ route('posts.destroy', $post) }}'"
                                                class="text-red-600 hover:text-red-800">
                                            Delete
                                        </button>
                                    @else
                                        <!-- Regular delete form -->
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                            <h2 class="text-xl font-semibold mb-2">
                                <a href="{{ route('posts.show', $post) }}" class="hover:underline">{{ $post->title }}</a>
                            </h2>
                            <p class="text-gray-800 mb-3">{{ Str::limit($post->content, 200) }}</p>
                            <div class="flex items-center space-x-4 text-gray-500">
                                <a href="{{ route('posts.show', $post) }}" class="flex items-center hover:text-blue-600">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    {{ number_format($post->threads->count()) }} {{ Str::plural('Thread', $post->threads->count()) }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $posts->appends(['search' => request('search'), 'filter' => $filter])->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 