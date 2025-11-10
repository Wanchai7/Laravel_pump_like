<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('ตะกร้าสินค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($cartItems->isEmpty())
                <div class="bg-secondary-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-white">
                        <p class="text-xl mb-4">ตะกร้าสินค้าของคุณว่างเปล่า</p>
                        <a href="{{ route('welcome') }}" class="inline-block bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600">เลือกซื้อสินค้าต่อ</a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="md:col-span-2 space-y-4">
                        @php $total = 0; @endphp
                        @foreach($cartItems as $item)
                            @php $total += $item->product->price * $item->quantity; @endphp
                            <div class="bg-secondary-900 p-4 rounded-lg shadow-md flex items-center space-x-4">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded-md">
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-white">{{ $item->product->name }}</h3>
                                    <p class="text-gray-400">{{ number_format($item->product->price, 2) }} บาท</p>
                                </div>
                                <div class="flex items-center">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" class="w-16 text-center bg-secondary-800 text-white border border-secondary-700 rounded-md focus:ring-primary-500 focus:border-primary-500"/>
                                        <button type="submit" class="ml-2 text-primary-400 hover:text-primary-500 text-sm">อัปเดต</button>
                                    </form>
                                </div>
                                <div class="text-white font-semibold">
                                    {{ number_format($item->product->price * $item->quantity, 2) }} บาท
                                </div>
                                <div>
                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div class="bg-secondary-900 p-6 rounded-lg shadow-md h-fit">
                        <h3 class="text-xl font-semibold text-white mb-4">สรุปยอดรวม</h3>
                        <div class="flex justify-between items-center text-gray-300 mb-6">
                            <span>ยอดรวม</span>
                            <span class="font-semibold text-white">{{ number_format($total, 2) }} บาท</span>
                        </div>
                        <div class="space-y-4">
                            <a href="{{ route('payment.show') }}" class="block text-center w-full bg-green-500 text-white py-3 px-4 rounded-md hover:bg-green-600 font-semibold">ดำเนินการชำระเงิน</a>
                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการล้างตะกร้าสินค้าทั้งหมด?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block text-center w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">ล้างตะกร้า</button>
                            </form>
                        </div>
                        <div class="text-center mt-6">
                            <a href="{{ route('welcome') }}" class="text-primary-400 hover:text-primary-500">หรือเลือกซื้อสินค้าต่อ</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
