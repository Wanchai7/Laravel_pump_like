<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('products.create') }}" class="bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600">Create Product</a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <a href="{{ route('products.show', $product) }}">
                                    <img src="{{ $product->image }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                                </a>
                                <div class="p-4">
                                    <a href="{{ route('products.show', $product) }}">
                                        <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                                    </a>
                                    <p class="text-gray-600">{{ $product->description }}</p>
                                    <p class="text-primary-500 font-semibold mt-2">{{ $product->price }} บาท</p>
                                    <div class="mt-4 flex justify-between items-center">
                                        <button class="w-full bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600">เพิ่มลงตะกร้า</button>
                                        <div class="flex">
                                            @can('update-product', $product)
                                                <a href="{{ route('products.edit', $product) }}" class="text-gray-500 hover:text-gray-700 ml-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('delete-product', $product)
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
