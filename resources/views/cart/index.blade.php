<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('ตะกร้าสินค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-secondary-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-secondary-900 border-b border-secondary-700">

                    @if ($cartItems->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-xl mb-4">ตะกร้าสินค้าของคุณว่างเปล่า</p>
                            <a href="{{ route('welcome') }}" class="bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600">เลือกซื้อสินค้าต่อ</a>
                        </div>
                    @else
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs text-gray-100 uppercase bg-secondary-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3">สินค้า</th>
                                    <th scope="col" class="px-6 py-3">ราคา</th>
                                    <th scope="col" class="px-6 py-3">จำนวน</th>
                                    <th scope="col" class="px-6 py-3 text-center">ยอดรวมย่อย</th>
                                    <th scope="col" class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($cartItems as $item)
                                    @php $total += $item->product->price * $item->quantity; @endphp
                                    <tr class="bg-secondary-900 border-b border-secondary-700 hover:bg-secondary-800">
                                        <td class="px-6 py-4 font-medium text-white whitespace-nowrap">{{ $item->product->name }}</td>
                                        <td class="px-6 py-4">{{ $item->product->price }} บาท</td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" class="w-16 text-center bg-secondary-800 text-white border border-secondary-700 rounded-md focus:ring-primary-500 focus:border-primary-500"/>
                                                <button type="submit" class="ml-2 bg-primary-500 text-white py-1 px-2 rounded-md hover:bg-primary-600">อัปเดต</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 text-center">{{ $item->product->price * $item->quantity }} บาท</td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">ลบ</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="flex justify-end mt-4">
                            <h3 class="text-xl font-semibold">ยอดรวม: {{ $total }} บาท</h3>
                        </div>

                        <div class="flex justify-between items-center mt-6">
                            <a href="{{ route('welcome') }}" class="text-primary-400 hover:text-primary-500">เลือกซื้อสินค้าต่อ</a>
                            <div class="flex space-x-4">
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">ล้างตะกร้า</button>
                                </form>
                                <a href="{{ route('payment.show') }}" class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600">ดำเนินการชำระเงิน</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
