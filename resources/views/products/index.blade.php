<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Products</h1>
                        <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add Product
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
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Image</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Title</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Brand</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Price(RM)</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="px-6 py-4 border-b">
                                            <img src="{{ $product->img_link }}" alt="{{ $product->title }}" class="w-16 h-16 object-cover">
                                        </td>
                                        <td class="px-6 py-4 border-b">
                                            <a href="{{ $product->product_link }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                                {{ $product->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 border-b">{{ $product->brand ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 border-b">{{ number_format($product->price, 2) }}</td>
                                        <td class="px-6 py-4 border-b">
                                            <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 mr-4">Edit</a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 