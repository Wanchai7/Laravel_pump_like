<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <img src="{{ $product->image }}" class="w-full h-96 object-cover" alt="{{ $product->name }}">
                    <div class="p-4">
                        <p class="text-gray-600">{{ $product->description }}</p>
                        <p class="text-primary-500 font-semibold mt-2">{{ $product->price }} บาท</p>
                        <div class="mt-4">
                            @can('update-product', $product)
                                <a href="{{ route('products.edit', $product) }}" class="bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600">Edit</a>
                            @endcan
                            @can('delete-product', $product)
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
