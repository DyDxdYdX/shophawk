<x-app-layout>
    <div x-data="{ showDeleteModal: false, deleteAction: '' }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4">
                    <a href="{{ route('forum') }}" class="text-gray-600 hover:text-gray-900">← Back to Posts</a>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1 class="text-2xl font-bold mb-4">{{ $post->title }}</h1>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-gray-600 text-sm">
                                <span>Posted by {{ $post->user->name }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            @if($post->user_id === auth()->id())
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                    </form>
                                </div>
                            @endif
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
                                            @if($thread->user_id === auth()->id() || auth()->user()->is_admin)
                                                <div class="flex items-center space-x-2">
                                                    @if($thread->user_id === auth()->id())
                                                        <button onclick="editThread({{ $thread->id }})" class="text-blue-600 hover:text-blue-800 text-sm">Edit</button>
                                                    @endif
                                                    @if(auth()->user()->is_admin && auth()->id() !== $thread->user_id)
                                                        <!-- Admin delete button -->
                                                        <button type="button" 
                                                                @click="showDeleteModal = true; deleteAction = '{{ route('threads.destroy', $thread) }}'"
                                                                class="text-xs text-red-600 hover:text-red-800">
                                                            Delete
                                                        </button>
                                                    @else
                                                        <!-- Regular delete form -->
                                                        <form action="{{ route('threads.destroy', $thread) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-xs text-red-600 hover:text-red-800">Delete</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mt-2">
                                            <div id="thread-content-{{ $thread->id }}">{{ $thread->content }}</div>
                                            <form id="edit-form-{{ $thread->id }}" action="{{ route('threads.update', $thread) }}" method="POST" class="hidden mt-2">
                                                @csrf
                                                @method('PUT')
                                                <textarea name="content" rows="3" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $thread->content }}</textarea>
                                                <div class="mt-2 space-x-2">
                                                    <button type="submit" class="text-sm bg-blue-600 text-white px-3 py-1 rounded">Save</button>
                                                    <button type="button" onclick="cancelEdit({{ $thread->id }})" class="text-sm bg-gray-500 text-white px-3 py-1 rounded">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal" 
             class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50"
             x-cloak>
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Delete Thread</h3>
                <form :action="deleteAction" method="POST" class="space-y-4">
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
                            Delete Thread
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editThread(threadId) {
            document.getElementById(`thread-content-${threadId}`).classList.add('hidden');
            document.getElementById(`edit-form-${threadId}`).classList.remove('hidden');
        }

        function cancelEdit(threadId) {
            document.getElementById(`thread-content-${threadId}`).classList.remove('hidden');
            document.getElementById(`edit-form-${threadId}`).classList.add('hidden');
        }
    </script>
</x-app-layout> 