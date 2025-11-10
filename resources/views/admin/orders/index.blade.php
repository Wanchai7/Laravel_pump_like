<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('จัดการคำสั่งซื้อ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-secondary-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-secondary-900 border-b border-secondary-700">
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-secondary-700">
                        <thead class="bg-secondary-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">รหัสคำสั่งซื้อ</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ลูกค้า</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ยอดรวม</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">สถานะ</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">วันที่สั่ง</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">รายละเอียด</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">แก้ไข</span>
                                </th>
                            </tr>
                        </thead>
                        @foreach ($orders as $order)
                            <tbody x-data="{ open: false }" class="bg-secondary-900 divide-y divide-secondary-700">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-white">{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-white">{{ $order->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-white">{{ number_format($order->total, 2) }} บาท</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status_color_class }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary-400">
                                        <button @click="open = !open" class="hover:text-primary-600">
                                            <span x-show="!open">ดูรายละเอียด</span>
                                            <span x-show="open">ซ่อนรายละเอียด</span>
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="bg-secondary-800 border border-secondary-700 text-white rounded-md focus:ring-primary-500 focus:border-primary-500">
                                                <option value="รอดำเนินการ" {{ $order->status === 'รอดำเนินการ' ? 'selected' : '' }}>รอดำเนินการ</option>
                                                <option value="ดำเนินการเสร็จเรียบร้อย" {{ $order->status === 'ดำเนินการเสร็จเรียบร้อย' ? 'selected' : '' }}>ดำเนินการเสร็จเรียบร้อย</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                                <tr x-show="open" x-cloak>
                                    <td colspan="7" class="p-4 bg-secondary-800">
                                        <h4 class="font-semibold text-white mb-2">รายการในคำสั่งซื้อ</h4>
                                        <table class="min-w-full divide-y divide-secondary-700">
                                            <thead class="bg-secondary-700">
                                                <tr>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">สินค้า</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">จำนวน</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ราคาต่อหน่วย</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ราคารวม</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-secondary-800 divide-y divide-secondary-700">
                                                @foreach ($order->items as $item)
                                                    <tr>
                                                        <td class="px-4 py-2 whitespace-nowrap text-white">{{ $item->product->name }}</td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-white">{{ $item->quantity }}</td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-white">{{ number_format($item->price, 2) }} บาท</td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-white">{{ number_format($item->price * $item->quantity, 2) }} บาท</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
