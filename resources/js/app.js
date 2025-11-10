import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    const cartIcon = document.getElementById('cart-icon');
    const cartModal = document.getElementById('cart-modal');
    const closeCartModal = document.getElementById('close-cart-modal');
    const cartModalBody = document.getElementById('cart-modal-body');
    const cartModalTotal = document.getElementById('cart-modal-total');
    const cartCount = document.getElementById('cart-count');

    if (cartIcon) {
        cartIcon.addEventListener('click', openCartModal);
    }

    if (closeCartModal) {
        closeCartModal.addEventListener('click', () => {
            cartModal.classList.add('translate-x-full');
        });
    }

    function openCartModal() {
        fetch('/api/cart')
            .then(response => response.json())
            .then(data => {
                updateCartModal(data.cartItems, data.total);
                cartModal.classList.remove('translate-x-full');
            });
    }

    function updateCartModal(items, total) {
        cartModalBody.innerHTML = '';
        if (items.length === 0) {
            cartModalBody.innerHTML = '<p class="text-white text-center">ตะกร้าสินค้าของคุณว่างเปล่า</p>';
        } else {
            items.forEach(item => {
                const cartItem = document.createElement('div');
                cartItem.classList.add('flex', 'items-center', 'mb-4', 'text-white');

                const itemSubtotal = item.product.price * item.quantity;

                cartItem.innerHTML = `
                    <img src="${item.product.image_url}" alt="${item.product.name}" class="w-16 h-16 object-cover rounded-md">
                    <div class="flex-grow ml-4">
                        <p class="font-semibold">${item.product.name}</p>
                        <p class="text-sm text-gray-400">${item.quantity} x ${parseFloat(item.product.price).toFixed(2)} บาท</p>
                    </div>
                    <div class="flex items-center">
                        <form class="update-cart-form" data-id="${item.id}">
                            <input type="number" name="quantity" value="${item.quantity}" class="w-12 text-center bg-secondary-700 border border-secondary-600 rounded-md text-sm p-1">
                            <button type="submit" class="text-primary-400 hover:text-primary-500 text-xs ml-2">อัปเดต</button>
                        </form>
                    </div>
                    <div class="font-semibold ml-4" style="width: 80px; text-align: right;">
                        ${itemSubtotal.toFixed(2)} บาท
                    </div>
                    <div class="ml-4">
                        <form class="remove-from-cart-form" data-id="${item.id}">
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </form>
                    </div>
                `;
                cartModalBody.appendChild(cartItem);
            });
        }
        cartModalTotal.textContent = `${parseFloat(total).toFixed(2)} บาท`;
        updateCartCount(items.length);
    }

    function updateCartCount(count) {
        if (cartCount) {
            cartCount.textContent = count;
        }
    }

    function updateCartInfo() {
        fetch('/api/cart')
            .then(response => response.json())
            .then(data => {
                if (data.cartItems) {
                    updateCartCount(data.cartItems.length);
                }
            })
            .catch(error => {
                console.error('Error fetching cart info:', error);
            });
    }

    document.body.addEventListener('submit', function (e) {
        if (e.target.matches('.update-cart-form')) {
            e.preventDefault();
            const form = e.target;
            const cartId = form.dataset.id;
            const quantity = form.querySelector('input[name=\"quantity\"]').value;

            fetch(`/cart/${cartId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content')
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(() => openCartModal());
        }

        if (e.target.matches('.remove-from-cart-form')) {
            e.preventDefault();
            const form = e.target;
            const cartId = form.dataset.id;

            fetch(`/cart/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content')
                }
            })
            .then(() => openCartModal());
        }

        if (e.target.matches('.add-to-cart-form')) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartInfo();
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: 'เพิ่มสินค้าลงในตะกร้าแล้ว',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                } else {
                    Swal.fire({
                        title: 'ผิดพลาด!',
                        text: data.message || 'ไม่สามารถเพิ่มสินค้าลงในตะกร้าได้',
                        icon: 'error',
                        confirmButtonText: 'ตกลง'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'ผิดพลาด!',
                    text: 'เกิดข้อผิดพลาดบางอย่าง',
                    icon: 'error',
                    confirmButtonText: 'ตกลง'
                });
            });
        }
    });

    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;

            fetch('/cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    updateCartInfo();
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: 'เพิ่มสินค้าลงในตะกร้าแล้ว',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                } else {
                    Swal.fire({
                        title: 'ผิดพลาด!',
                        text: 'ไม่สามารถเพิ่มสินค้าลงในตะกร้าได้',
                        icon: 'error',
                        confirmButtonText: 'ตกลง'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.');
            });
        });
    });

    // Initial cart count update on page load
    updateCartInfo();
});
