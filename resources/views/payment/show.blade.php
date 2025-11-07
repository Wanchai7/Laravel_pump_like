<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('ชำระเงิน') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-secondary-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white text-center">
                    <h3 class="text-2xl font-semibold mb-4">สแกน QR Code เพื่อชำระเงิน</h3>
                    <div class="flex justify-center mb-4">
                        <img src="{{ $qrCodeUrl }}" alt="QR Code">
                    </div>
                    <p class="text-lg">กรุณาสแกน QR Code ด้วยแอปธนาคารบนมือถือของคุณเพื่อชำระเงิน</p>
                    <p class="text-lg mt-2">ยอดชำระ: <span class="font-semibold">{{ $order->total }}</span> บาท</p>
                    <div class="mt-8">
                        <p class="text-lg">กำลังรอการชำระเงิน...</p>
                        <div class="flex justify-center items-center mt-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderId = {{ $order->id }};

            const interval = setInterval(function() {
                fetch(`/orders/${orderId}/status`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'paid') {
                            clearInterval(interval);
                            window.location.href = "{{ route('orders.index') }}";
                        }
                    });
            }, 5000);
        });
    </script>
    @endpush
</x-app-layout>
