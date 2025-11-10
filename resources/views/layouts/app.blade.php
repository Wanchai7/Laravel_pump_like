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
        <div class="flex flex-col min-h-screen bg-background">
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
            <main class="flex-grow">
                {{ $slot }}
            </main>

                        <footer class="bg-secondary-900 text-white py-6">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                                <p class="text-lg font-semibold mb-4">หากพบปัญหาในการใช้งานหรือต้องการความช่วยเหลือ โปรดติดต่อ:</p>
                                <div class="flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-6">
                                    <a href="#" class="text-primary-400 hover:underline flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19.999 3.999H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V5.999c0-1.103-.897-2-2-2zm-11.5 11.5h-2v-2h2v2zm0-4h-2v-2h2v2zm4 4h-2v-2h2v2zm0-4h-2v-2h2v2zm4 4h-2v-2h2v2zm0-4h-2v-2h2v2z"/></svg>
                                        LINE: wanchai8439
                                    </a>
                                    <a href="#" class="text-primary-400 hover:underline flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.776-3.89 1.094 0 2.24.195 2.24.195v2.45h-1.26c-1.247 0-1.646.773-1.646 1.563V12h2.773l-.443 2.89h-2.33V22c4.781-.75 8.438-4.887 8.438-9.878z"/></svg>
                                        FACEBOOK: View Wanchai && ยีนส์ ครับ
                                    </a>
                                    <a href="#" class="text-primary-400 hover:underline flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7.5 2.5h9a5 5 0 015 5v9a5 5 0 01-5 5h-9a5 5 0 01-5-5v-9a5 5 0 015-5zm0 2a3 3 0 00-3 3v9a3 3 0 003 3h9a3 3 0 003-3v-9a3 3 0 00-3-3h-9zm7.5 3a.5.5 0 110 1 .5.5 0 010-1zM12 9a3 3 0 110 6 3 3 0 010-6zm0 2a1 1 0 100 2 1 1 0 000-2z"/></svg>
                                        INSTAGRAM: yeans_cup && wxnchxi._
                                    </a>
                                </div>
                            </div>
                        </footer>        </div>

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
