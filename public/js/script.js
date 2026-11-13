// Menampilkan dropdown
function toggleDropdown() {
    const dropdown = document.getElementById('dropdownMenu');
    dropdown.classList.toggle('show');
}

// Klik di luar dropdown menutup menu
window.addEventListener('click', function(e) {
    const dropdown = document.getElementById('dropdownMenu');
    const trigger = document.getElementById('userDropdown');

    if (!trigger.contains(e.target)) {
        dropdown.classList.remove('show');
        }
});

// Menampilkan password
function togglePassword() {
    const passwordInput = document.getElementById("password");
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
}

document.addEventListener('DOMContentLoaded', () => {
    const cartCountElement = document.getElementById('cart-count');
    const cartTotalElement = document.getElementById('cart-total');
    const miniCart = document.getElementById('mini-cart');

    // ✅ Fungsi untuk menampilkan cart dari server saat halaman dimuat
    function fetchCart() {
        fetch('/cart/status', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.cart_count > 0) {
                cartCountElement.innerText = `${data.cart_count} item${data.cart_count > 1 ? 's' : ''}`;
                cartTotalElement.innerText = `Rp ${data.total.toLocaleString('id-ID')}`;
                miniCart.classList.remove('hidden');
            }
        })
        .catch(err => console.error('Error fetching cart:', err));
    }

    // 🔄 Panggil saat load
    fetchCart();

    // 🛒 Tambah ke keranjang
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', () => {
            const menuId = button.dataset.menuId;

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ menu_id: menuId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.cart_count !== undefined && data.total !== undefined) {
                    cartCountElement.innerText = `${data.cart_count} item${data.cart_count > 1 ? 's' : ''}`;
                    cartTotalElement.innerText = `Rp ${data.total.toLocaleString('id-ID')}`;
                    miniCart.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Gagal menambahkan ke keranjang:', error);
            });
        });
    });

    if (miniCart) {
        miniCart.addEventListener('click', () => {
            const checkoutUrl = miniCart.getAttribute('data-checkout-url');
            if (checkoutUrl) {
                window.location.href = checkoutUrl;
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {
    // +/- quantity
    document.querySelectorAll('.increase-btn, .decrease-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const isIncrease = btn.classList.contains('increase-btn');
            const parent = btn.closest('.cart-item');
            const menuId = parent.getAttribute('data-id');

            fetch('/cart/update-quantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    menu_id: menuId,
                    type: isIncrease ? 'increase' : 'decrease'
                })
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    location.reload(); // Refresh to reflect updates
                }
            });
        });
    });

    // Clear Cart
    const clearBtn = document.getElementById('clear-cart-btn');
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            if (confirm('Yakin ingin mengosongkan keranjang?')) {
                fetch('/cart/clear', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        });
    }
});
