<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Add Alert Message -->
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">About this website</h1>
                    
                    <div class="space-y-6">
                        <div class="prose max-w-none">
                            <p class="mb-4">This website is created for educational purposes as part of a final year project. 
                            It serves as a testing platform to demonstrate and evaluate web development concepts and practices.</p>
                            
                            <p>Shophawk Guru - Shop Assisting Tool is a web application designed to assist user in making online purchases on e-commerce sites. This project seeks to tackle issues such as deal discovery difficulty, product choice overwhelm and pricing transparency issue.</p>
                            
                        </div>

                        <!-- Feedback Form Section -->
                        @if (!auth()->user()->is_admin)
                        <div class="mt-8">
                            <h2 class="text-xl font-semibold mb-4">Submit Feedback</h2>
                            <form action="{{ route('feedback.store') }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                        <select name="category" id="category" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('category') border-red-500 @enderror">
                                            <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>General</option>
                                            <option value="bug" {{ old('category') == 'bug' ? 'selected' : '' }}>Bug Report</option>
                                            <option value="feature" {{ old('category') == 'feature' ? 'selected' : '' }}>Feature Request</option>
                                            <option value="improvement" {{ old('category') == 'improvement' ? 'selected' : '' }}>Improvement</option>
                                        </select>
                                        @error('category')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <textarea name="feedback" rows="4" 
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('feedback') border-red-500 @enderror"
                                            placeholder="Share your thoughts with us...">{{ old('feedback') }}</textarea>
                                        @error('feedback')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <button type="submit" 
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Submit Feedback
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif

                        <!-- Feedback History Section -->
                        <div class="mt-8 space-y-6">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold">
                                    @if (auth()->user()->is_admin)
                                        All Feedback
                                    @else
                                        Your Feedback History
                                    @endif
                                </h2>
                                @if (auth()->user()->is_admin)
                                    <a href="{{ route('feedback.export') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download Report
                                    </a>
                                @endif
                            </div>
                            @forelse ($feedbacks as $feedback)
                                <div class="bg-gray-50 p-4 rounded-lg shadow-sm" data-feedback-id="{{ $feedback->id }}" data-category="{{ $feedback->category }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-grow">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $feedback->category === 'bug' ? 'bg-red-100 text-red-800' : 
                                                   ($feedback->category === 'feature' ? 'bg-green-100 text-green-800' : 
                                                   ($feedback->category === 'improvement' ? 'bg-blue-100 text-blue-800' : 
                                                    'bg-gray-100 text-gray-800')) }}">
                                                {{ ucfirst($feedback->category) }}
                                            </span>
                                            <p class="text-gray-800 mt-2">{{ $feedback->feedback }}</p>
                                            <span class="text-sm text-gray-500">Submitted: {{ $feedback->created_at->diffForHumans() }}</span>
                                            @if (auth()->user()->is_admin)
                                                <div class="mt-1">
                                                    <span class="text-sm text-gray-500">By: {{ $feedback->name }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        @if (!auth()->user()->is_admin)
                                        <div class="flex space-x-2">
                                            <button onclick="editFeedback({{ $feedback->id }}, '{{ addslashes($feedback->feedback) }}')" 
                                                    class="text-blue-600 hover:text-blue-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                            <form action="{{ route('feedback.destroy', $feedback) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this feedback?')" 
                                                        class="text-red-600 hover:text-red-800">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 italic">You haven't submitted any feedback yet.</p>
                            @endforelse
                        </div>

                        <!-- Edit Feedback Modal -->
                        <div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <h3 class="text-lg font-medium mb-4">Edit Feedback</h3>
                                <form id="editForm" action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="feedback" id="editFeedbackText" rows="4" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                    <div class="mt-2">
                                        <label for="editCategory" class="block text-sm font-medium text-gray-700">Category</label>
                                        <select name="category" id="editCategory" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="general">General</option>
                                            <option value="bug">Bug Report</option>
                                            <option value="feature">Feature Request</option>
                                            <option value="improvement">Improvement</option>
                                        </select>
                                    </div>
                                    <div class="mt-4 flex justify-end space-x-2">
                                        <button type="button" onclick="closeEditModal()" 
                                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                            Cancel
                                        </button>
                                        <button type="submit" 
                                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <script>
                        function editFeedback(id, feedback) {
                            const feedbackElement = document.querySelector(`[data-feedback-id="${id}"]`);
                            document.getElementById('editModal').classList.remove('hidden');
                            document.getElementById('editFeedbackText').value = feedback;
                            document.getElementById('editCategory').value = feedbackElement.dataset.category;
                            document.getElementById('editForm').action = `/feedback/${id}`;
                        }

                        function closeEditModal() {
                            document.getElementById('editModal').classList.add('hidden');
                        }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 