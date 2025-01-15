<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('News Management') }}
            </h2>
            <a href="{{ route('news.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create News Article
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($news as $article)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($article->status) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->published_at?->format('Y-m-d H:i') ?? 'Not published' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('news.edit', $article) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                        <form action="{{ route('news.destroy', $article) }}" method="POST" class="inline" id="delete-form-{{ $article->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="text-red-600 hover:text-red-900"
                                                    onclick="if(confirm('Are you sure you want to delete this article?')) document.getElementById('delete-form-{{ $article->id }}').submit()">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $news->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 