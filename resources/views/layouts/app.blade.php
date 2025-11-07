<!DOCTYPE html>
<html lang="th">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans antialiased text-lg">
        <div class="min-h-screen bg-background">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-secondary-900 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('scripts')

        <!-- Cart Modal -->
        <div id="cart-modal" class="fixed top-0 right-0 h-full w-1/3 bg-secondary-800 shadow-lg z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
            <div class="flex justify-between items-center p-4 border-b border-secondary-700">
                <h2 class="text-xl font-semibold text-white">ตะกร้าสินค้า</h2>
                <button id="close-cart-modal" class="text-gray-300 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="cart-modal-body" class="p-4 overflow-y-auto">
                <!-- Cart items will be injected here by JavaScript -->
            </div>
            <div class="p-4 border-t border-secondary-700">
                <div class="flex justify-between items-center font-semibold text-white">
                    <span>ยอดรวม:</span>
                    <span id="cart-modal-total">0 บาท</span>
                </div>
                <a href="{{ route('cart.index') }}" class="block text-center w-full mt-4 bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600">ชำระเงิน</a>
            </div>
        </div>

    </body>
</html>
