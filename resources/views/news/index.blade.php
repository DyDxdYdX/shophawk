<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">News Articles</h1>
                        <a href="{{ route('news.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create News Article
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Title</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Status</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Published At</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($news as $article)
                                    <tr>
                                        <td class="px-6 py-4 border-b">{{ $article->title }}</td>
                                        <td class="px-6 py-4 border-b">{{ ucfirst($article->status) }}</td>
                                        <td class="px-6 py-4 border-b">{{ $article->published_at?->format('Y-m-d H:i') ?? 'Not published' }}</td>
                                        <td class="px-6 py-4 border-b">
                                            <a href="{{ route('news.edit', $article) }}" class="text-blue-600 hover:text-blue-900 mr-4">Edit</a>
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
    </div>
</x-app-layout> 