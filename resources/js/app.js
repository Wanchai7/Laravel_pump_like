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
            cartModalBody.innerHTML = '<p>Your cart is empty.</p>';
        } else {
            items.forEach(item => {
                const cartItem = document.createElement('div');
                cartItem.classList.add('flex', 'justify-between', 'items-center', 'mb-4');
                cartItem.innerHTML = `
                    <div>
                        <p class=\"font-semibold\">${item.product.name}</p>
                        <p class=\"text-gray-200\">${item.quantity} x ${item.product.price} บาท</p>
                    </div>
                    <div>
                        <form class=\"update-cart-form\" data-id=\"${item.id}\">
                            <input type=\"number\" name=\"quantity\" value=\"${item.quantity}\" class=\"w-16 text-center border\">
                            <button type=\"submit\" class=\"text-blue-500 hover:text-blue-700\">Update</button>
                        </form>
                        <form class=\"remove-from-cart-form\" data-id=\"${item.id}\">
                            <button type=\"submit\" class=\"text-red-500 hover:text-red-700\">Remove</button>
                        </form>
                    </div>
                `;
                cartModalBody.appendChild(cartItem);
            });
        }
        cartModalTotal.textContent = `${total} บาท`;
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
