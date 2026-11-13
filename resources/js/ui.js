/** Interaksi kecil di seluruh situs: menu, dropdown, konfirmasi, toast. */

export function showToast(message, tone = 'default') {
    const host = document.querySelector('[data-toasts]');
    if (!host) return;

    const toast = document.createElement('div');
    toast.className = `toast${tone === 'error' ? ' toast--error' : ''}`;
    toast.textContent = message;
    host.appendChild(toast);

    setTimeout(() => toast.remove(), 2800);
}

// Menu navigasi di layar kecil
document.addEventListener('click', (event) => {
    const toggle = event.target.closest('[data-nav-toggle]');
    if (toggle) {
        const nav = document.querySelector('[data-nav]');
        const open = nav.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', String(open));
        return;
    }

    const sidebarToggle = event.target.closest('[data-sidebar-toggle]');
    if (sidebarToggle) {
        const sidebar = document.querySelector('[data-sidebar]');
        const open = sidebar.classList.toggle('is-open');
        sidebarToggle.setAttribute('aria-expanded', String(open));
    }

    // Tutup dropdown akun saat klik di luar
    document.querySelectorAll('[data-user-menu][open]').forEach((menu) => {
        if (!menu.contains(event.target)) menu.removeAttribute('open');
    });

    // Tampilkan / sembunyikan password
    const reveal = event.target.closest('[data-toggle-password]');
    if (reveal) {
        const input = document.getElementById(reveal.dataset.togglePassword);
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        reveal.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    document.querySelectorAll('[data-user-menu][open]').forEach((menu) => menu.removeAttribute('open'));
});

// Konfirmasi sebelum kirim form: <form data-confirm="Yakin?">
document.addEventListener('submit', (event) => {
    const message = event.target.dataset?.confirm;
    if (message && !window.confirm(message)) event.preventDefault();
});

// Kirim otomatis saat pilihan berubah: <select data-autosubmit>
document.addEventListener('change', (event) => {
    if (event.target.matches('[data-autosubmit]')) event.target.form.requestSubmit();
});

// Muat ulang halaman berkala saat tab terlihat: <div data-autorefresh="30">
const refresh = document.querySelector('[data-autorefresh]');
if (refresh) {
    setInterval(() => {
        if (document.visibilityState === 'visible') window.location.reload();
    }, Number(refresh.dataset.autorefresh) * 1000);
}
