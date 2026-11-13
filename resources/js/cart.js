import { showToast } from './ui';

const drawer = document.getElementById('cart-drawer');
const backdrop = document.querySelector('[data-cart-backdrop]');
const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
const rupiah = (n) => 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
const escapeHtml = (s) =>
    String(s).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c]);

let state = { count: 0, subtotal: 0, lines: [] };

async function request(method, url, body) {
    const response = await fetch(url, {
        method,
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: body ? JSON.stringify(body) : undefined,
    });

    if (!response.ok) throw new Error(`HTTP ${response.status}`);
    return response.json();
}

function render() {
    document.querySelectorAll('[data-cart-count]').forEach((el) => {
        el.textContent = state.count;
        el.hidden = state.count === 0;
    });

    if (!drawer) return;

    const empty = state.lines.length === 0;
    drawer.querySelector('[data-cart-empty]').hidden = !empty;
    drawer.querySelector('[data-cart-foot]').hidden = empty;
    drawer.querySelector('[data-cart-subtotal]').textContent = rupiah(state.subtotal);

    drawer.querySelector('[data-cart-lines]').innerHTML = state.lines
        .map(
            (line) => `
        <li class="cart-line">
            <div class="cart-line__thumb">${
                line.image
                    ? `<img src="${escapeHtml(line.image)}" alt="">`
                    : escapeHtml(line.name.charAt(0))
            }</div>
            <div>
                <p class="cart-line__name">${escapeHtml(line.name)}</p>
                <p class="cart-line__price">${rupiah(line.price)}</p>
            </div>
            <div class="stepper" role="group" aria-label="Jumlah ${escapeHtml(line.name)}">
                <button type="button" data-cart-step data-menu-id="${line.id}" data-quantity="${line.quantity - 1}" aria-label="Kurangi">&minus;</button>
                <span>${line.quantity}</span>
                <button type="button" data-cart-step data-menu-id="${line.id}" data-quantity="${line.quantity + 1}" aria-label="Tambah">+</button>
            </div>
        </li>`
        )
        .join('');
}

async function apply(promise, { reload = false } = {}) {
    try {
        state = await promise;
        render();
        if (reload) window.location.reload();
        return true;
    } catch {
        showToast('Keranjang gagal diperbarui. Coba lagi.', 'error');
        return false;
    }
}

function openDrawer() {
    drawer.classList.add('is-open');
    backdrop.hidden = false;
    document.body.classList.add('has-drawer');
    drawer.querySelector('[data-cart-close]').focus();
}

function closeDrawer() {
    drawer.classList.remove('is-open');
    backdrop.hidden = true;
    document.body.classList.remove('has-drawer');
}

document.addEventListener('click', async (event) => {
    if (event.target.closest('[data-cart-open]')) return drawer && openDrawer();
    if (event.target.closest('[data-cart-close]') || event.target === backdrop) return closeDrawer();

    const add = event.target.closest('[data-cart-add]');
    if (add) {
        add.disabled = true;
        const ok = await apply(request('POST', drawer.dataset.addUrl, { menu_id: Number(add.dataset.menuId) }));
        add.disabled = false;
        if (ok) showToast(`${add.dataset.menuName} masuk keranjang`);
        return;
    }

    const step = event.target.closest('[data-cart-step]');
    if (step) {
        const url = drawer.dataset.updateUrl.replace('__ID__', step.dataset.menuId);
        const reload = step.hasAttribute('data-reload');
        step.disabled = true;
        await apply(request('PATCH', url, { quantity: Number(step.dataset.quantity) }), { reload });
        step.disabled = false;
        return;
    }

    const clear = event.target.closest('[data-cart-clear]');
    if (clear && window.confirm('Kosongkan semua isi keranjang?')) {
        await apply(request('DELETE', drawer.dataset.clearUrl), { reload: clear.hasAttribute('data-reload') });
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && drawer?.classList.contains('is-open')) closeDrawer();
});

if (drawer) {
    apply(request('GET', drawer.dataset.showUrl));
}
