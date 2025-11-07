<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ประวัติการสั่งซื้อ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse ($orders as $order)
                        <div class="mb-6 p-4 border rounded-lg">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold">คำสั่งซื้อ #{{ $order->id }}</h3>
                                    <p class="text-sm text-gray-600">วันที่สั่ง: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status === 'รอดำเนินการ' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">สินค้า</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">จำนวน</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ราคา</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ราคารวม</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->product->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->price, 2) }} บาท</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->price * $item->quantity, 2) }} บาท</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right mt-4">
                                <p class="font-semibold">ยอดรวมทั้งสิ้น: {{ number_format($order->total, 2) }} บาท</p>
                            </div>
                        </div>
                    @empty
                        <p>คุณยังไม่มีคำสั่งซื้อ</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
