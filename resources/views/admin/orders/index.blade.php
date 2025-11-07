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
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">แก้ไข</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-secondary-900 divide-y divide-secondary-700">
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-white">{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-white">{{ $order->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-white">{{ number_format($order->total, 2) }} บาท</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status === 'รอดำเนินการ' ? 'bg-yellow-500 text-yellow-900' : 'bg-green-500 text-green-900' }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $order->created_at->format('d/m/Y H:i') }}</td>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
