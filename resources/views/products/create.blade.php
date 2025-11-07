<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Create Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-secondary-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-200 text-sm font-bold mb-2">Name:</label>
                            <input type="text" name="name" id="name" class="bg-secondary-800 border border-secondary-700 text-white rounded-md focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-200 text-sm font-bold mb-2">Description:</label>
                            <textarea name="description" id="description" class="bg-secondary-800 border border-secondary-700 text-white rounded-md focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-gray-200 text-sm font-bold mb-2">Price:</label>
                            <input type="text" name="price" id="price" class="bg-secondary-800 border border-secondary-700 text-white rounded-md focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-gray-200 text-sm font-bold mb-2">Image:</label>
                            <input type="file" name="image" id="image" class="bg-secondary-800 border border-secondary-700 text-white rounded-md focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                        </div>
                        <button type="submit" class="bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
