<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="product_link" :value="__('Product Link')" />
                            <x-text-input id="product_link" class="block mt-1 w-full" type="url" name="product_link" :value="old('product_link')" required />
                            <x-input-error :messages="$errors->get('product_link')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" step="0.01" :value="old('price')" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="img_link" :value="__('Image Link')" />
                            <x-text-input id="img_link" class="block mt-1 w-full" type="url" name="img_link" :value="old('img_link')" required />
                            <x-input-error :messages="$errors->get('img_link')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="brand" :value="__('Brand')" />
                            <x-text-input id="brand" class="block mt-1 w-full" type="text" name="brand" :value="old('brand')" />
                            <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Create Product') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 