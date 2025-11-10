<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('บริการของเรา') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-secondary-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    @can('create-product')
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('products.create') }}" class="bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600">สร้างบริการ</a>
                    </div>
                    @endcan
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                            <div class="bg-secondary-800 shadow-md overflow-hidden rounded-lg">
                                <a href="{{ route('products.show', $product) }}">
                                    <img src="{{ $product->image_url }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                                </a>
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg"><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></h3>
                                    <p class="text-gray-200">{{ $product->description }}</p>
                                    <p class="text-primary-400 font-semibold mt-2">{{ $product->price }} บาท</p>
                                    <form action="{{ route('cart.store') }}" method="POST" class="mt-4 add-to-cart-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="w-full bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600">เพิ่มลงตะกร้า</button>
                                    </form>
                                    <div class="mt-4 flex justify-end space-x-4">
                                        @can('update-product', $product)
                                            <a href="{{ route('products.edit', $product) }}" class="inline-block bg-yellow-500 text-white py-1 px-3 rounded-md hover:bg-yellow-600 text-sm">แก้ไข</a>
                                        @endcan
                                        @can('delete-product', $product)
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสินค้านี้?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-block bg-red-500 text-white py-1 px-3 rounded-md hover:bg-red-600 text-sm">ลบ</button>
                                            </form>
                                        @endcan
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
