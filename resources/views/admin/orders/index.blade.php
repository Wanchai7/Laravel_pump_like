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
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">ลบ</span>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if ($order->status === 'ดำเนินการเสร็จเรียบร้อย')
                                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบคำสั่งซื้อนี้?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">ลบ</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                <tr x-show="open" x-cloak>
                                    <td colspan="8" class="p-4 bg-secondary-800">
                                        <h4 class="font-semibold text-white mb-2">รายการในคำสั่งซื้อ</h4>
                                        <table class="min-w-full divide-y divide-secondary-700">
                                            <thead class="bg-secondary-700">
                                                <tr>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">สินค้า</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ลิงก์</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">จำนวน</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ราคาต่อหน่วย</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ราคารวม</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-secondary-800 divide-y divide-secondary-700">
                                                @foreach ($order->items as $item)
                                                    <tr>
                                                        <td class="px-4 py-2 whitespace-nowrap text-white">{{ $item->product->name }}</td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-white">
                                                            @if($item->link)
                                                                <div class="flex items-center space-x-2">
                                                                    <a href="{{ $item->link }}" target="_blank" class="text-primary-400 hover:text-primary-600">
                                                                        {{ $item->link }}
                                                                    </a>
                                                                    <button type="button" onclick="copyToClipboard('{{ $item->link }}')" class="text-gray-400 hover:text-gray-200 focus:outline-none">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1.5M9 3h6l-3 3L9 3zM15 7v3m0 0v3m0-3h3m-3 0H9m12-2a2 2 0 00-2-2H9a2 2 0 00-2 2v10a2 2 0 002 2h6a2 2 0 002-2V9a2 2 0 00-2-2z"></path></svg>
                                                                    </button>
                                                                </div>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
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
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('คัดลอกลิงก์แล้ว: ' + text);
        }, function(err) {
            console.error('ไม่สามารถคัดลอกลิงก์ได้: ', err);
        });
    }
</script>
</x-app-layout>
