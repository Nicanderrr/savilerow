import 'bootstrap';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;
Alpine.start();

const money = (value) => new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', maximumFractionDigits: 0 }).format(value);
const getCart = () => JSON.parse(localStorage.getItem('savile_cart') || '[]');
const setCart = (items) => { localStorage.setItem('savile_cart', JSON.stringify(items)); renderCart(); };

function renderCart() {
  const items = getCart();
  const count = items.reduce((sum, item) => sum + item.quantity, 0);
  document.querySelectorAll('[data-cart-count]').forEach((el) => { el.textContent = count; el.classList.toggle('hidden', count === 0); });
  const list = document.querySelector('[data-cart-list]');
  const subtotal = items.reduce((sum, item) => sum + item.price * item.quantity, 0);
  document.querySelectorAll('[data-cart-subtotal]').forEach((el) => { el.textContent = money(subtotal); });
  if (list) {
    if (!items.length) {
      list.innerHTML = '<div class="store-empty-state"><h2 class="font-serif text-3xl uppercase">Your bag is empty</h2><p class="mt-4 text-[13px] text-cl-muted">Start with new-season tailoring, shoes, bags, or fragrance.</p><a href="/collections/all/products" class="btn-outline mt-10 inline-block">Continue shopping</a></div>';
    } else {
      list.innerHTML = items.map((item, index) => `<li class="cart-line"><img src="${item.image}" alt="${item.name}" class="cart-line-image"><div class="cart-line-body"><a href="/products/${item.slug}" class="font-serif text-lg uppercase leading-tight">${item.name}</a><p class="mt-1 text-[12px] text-cl-muted">${[item.color,item.size,item.fulfillment].filter(Boolean).join(' &middot; ')}</p><div class="mt-auto flex flex-col gap-3 pt-4 sm:flex-row sm:items-center sm:justify-between"><div class="qty-control"><button data-qty="${index}" data-delta="-1" aria-label="Decrease quantity">-</button><span>${item.quantity}</span><button data-qty="${index}" data-delta="1" aria-label="Increase quantity">+</button></div><p class="text-[13px] font-medium sm:text-right">${money(item.price * item.quantity)}</p></div><button class="mt-3 self-start text-[11px] uppercase tracking-widest text-cl-muted hover:text-black" data-remove="${index}">Remove</button></div></li>`).join('');
    }
  }
  const checkoutList = document.querySelector('[data-checkout-list]');
  if (checkoutList) {
    checkoutList.innerHTML = items.length ? items.map((item) => `<li class="checkout-line"><span class="min-w-0"><span class="block truncate font-medium">${item.name}</span><span class="text-xs text-cl-muted">Qty ${item.quantity}</span></span><span>${money(item.price * item.quantity)}</span></li>`).join('') : '<li class="rounded-2xl border border-dashed border-cl-gray-mid p-5 text-center text-cl-muted">Your bag is empty.</li>';
    const shipping = subtotal > 500 || subtotal === 0 ? 0 : 25;
    document.querySelectorAll('[data-checkout-shipping]').forEach((el) => { el.textContent = shipping === 0 ? 'Complimentary' : money(shipping); });
    document.querySelectorAll('[data-checkout-total]').forEach((el) => { el.textContent = money(subtotal + shipping); });
  }
}

document.addEventListener('click', (event) => {
  const toggle = event.target.closest('[data-toggle]');
  if (toggle) document.querySelector(toggle.dataset.toggle)?.classList.toggle('open');
  const close = event.target.closest('[data-close]');
  if (close) document.querySelector(close.dataset.close)?.classList.remove('open');
  const add = event.target.closest('[data-add-product]');
  if (add) {
    const product = JSON.parse(add.dataset.addProduct);
    const size = document.querySelector('[name="size"]:checked')?.value || document.querySelector('[name="size"]')?.value || '';
    const color = document.querySelector('[name="color"]:checked')?.value || document.querySelector('[name="color"]')?.value || '';
    const fulfillment = document.querySelector('[name="fulfillment"]:checked')?.value || 'Ship to me';
    const key = `${product.slug}-${size}-${color}-${fulfillment}`;
    const items = getCart();
    const existing = items.find((item) => item.key === key);
    if (existing) existing.quantity += 1; else items.push({ ...product, key, size, color, fulfillment, quantity: 1 });
    setCart(items);
    document.querySelector('#bag-drawer')?.classList.add('open');
  }
  const qty = event.target.closest('[data-qty]');
  if (qty) { const items = getCart(); const index = Number(qty.dataset.qty); items[index].quantity += Number(qty.dataset.delta); setCart(items.filter((item) => item.quantity > 0)); }
  const remove = event.target.closest('[data-remove]');
  if (remove) { const items = getCart(); items.splice(Number(remove.dataset.remove), 1); setCart(items); }
});

window.addEventListener('scroll', () => {
  const header = document.querySelector('[data-site-header]');
  if (header?.classList.contains('header-home')) header.classList.toggle('past-hero', window.scrollY > 48);
}, { passive: true });

document.addEventListener('DOMContentLoaded', () => {
  renderCart();

  document.querySelectorAll('[data-paystack-checkout]').forEach((form) => {
    form.addEventListener('submit', async (event) => {
      event.preventDefault();

      const errorBox = form.querySelector('[data-checkout-error]');
      const submit = form.querySelector('[data-paystack-submit]');
      const items = getCart();

      if (!items.length) {
        if (errorBox) {
          errorBox.textContent = 'Your shopping bag is empty.';
          errorBox.classList.remove('hidden');
        }
        return;
      }

      if (errorBox) {
        errorBox.textContent = '';
        errorBox.classList.add('hidden');
      }

      submit?.setAttribute('disabled', 'disabled');
      const originalText = submit?.textContent;
      if (submit) submit.textContent = 'Redirecting to Paystack...';

      try {
        const formData = new FormData(form);
        const payload = Object.fromEntries(formData.entries());
        payload.items = items.map((item) => ({
          slug: item.slug,
          quantity: item.quantity,
          size: item.size || '',
          color: item.color || '',
          fulfillment: item.fulfillment || '',
        }));

        const response = await fetch(form.action, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
          },
          body: JSON.stringify(payload),
        });

        const data = await response.json();

        if (!response.ok || !data.authorization_url) {
          throw new Error(data.message || 'Unable to start Paystack checkout.');
        }

        window.location.href = data.authorization_url;
      } catch (error) {
        if (errorBox) {
          errorBox.textContent = error.message;
          errorBox.classList.remove('hidden');
        }
        submit?.removeAttribute('disabled');
        if (submit) submit.textContent = originalText || 'Pay securely with Paystack';
      }
    });
  });

  document.querySelectorAll('[data-image-preview-input]').forEach((input) => {
    input.addEventListener('change', () => {
      const target = document.querySelector(input.dataset.imagePreviewInput);
      if (!target) return;

      const files = Array.from(input.files || []);
      if (!files.length) return;

      target.querySelectorAll('[data-live-preview]').forEach((preview) => preview.remove());

      files.forEach((file) => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.addEventListener('load', () => {
          const frame = document.createElement('div');
          frame.className = 'relative overflow-hidden rounded-3xl border border-amber-300 bg-slate-100';
          frame.dataset.livePreview = 'true';
          frame.innerHTML = `<img src="${reader.result}" alt="${file.name}" class="aspect-[3/4] w-full object-cover"><span class="absolute left-3 top-3 rounded-full bg-amber-500 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-white">New</span>`;
          target.appendChild(frame);
        });
        reader.readAsDataURL(file);
      });
    });
  });

  document.querySelectorAll('[data-single-image-preview-input]').forEach((input) => {
    input.addEventListener('change', () => {
      const target = document.querySelector(input.dataset.singleImagePreviewInput);
      const file = input.files?.[0];
      if (!target || !file || !file.type.startsWith('image/')) return;

      const reader = new FileReader();
      reader.addEventListener('load', () => {
        target.innerHTML = `<img src="${reader.result}" alt="${file.name}" class="aspect-square w-full object-cover">`;
      });
      reader.readAsDataURL(file);
    });
  });

  document.querySelectorAll('[data-video-preview-input]').forEach((input) => {
    input.addEventListener('change', () => {
      const target = document.querySelector(input.dataset.videoPreviewInput);
      const file = input.files?.[0];
      if (!target || !file || !file.type.startsWith('video/')) return;

      const src = URL.createObjectURL(file);
      target.innerHTML = `<video src="${src}" class="aspect-square w-full object-cover" muted loop playsinline controls></video>`;
    });
  });

  const shell = document.querySelector('[data-admin-shell]');
  if (shell) {
    const collapsed = localStorage.getItem('admin.sidebar.collapsed') === 'true';
    shell.classList.toggle('admin-collapsed', collapsed);
    shell.classList.toggle('dark', localStorage.getItem('admin.theme') === 'dark');
    document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => button.addEventListener('click', () => {
      shell.classList.toggle('admin-collapsed');
      localStorage.setItem('admin.sidebar.collapsed', shell.classList.contains('admin-collapsed'));
    }));
    const adminSidebar = document.querySelector('.admin-sidebar');
    const adminSidebarOverlay = document.querySelector('[data-admin-sidebar-overlay]');
    const setAdminSidebarOpen = (open) => {
      adminSidebar?.classList.toggle('mobile-open', open);
      adminSidebarOverlay?.classList.toggle('is-open', open);
    };
    document.querySelectorAll('[data-mobile-sidebar]').forEach((button) => button.addEventListener('click', () => {
      setAdminSidebarOpen(!adminSidebar?.classList.contains('mobile-open'));
    }));
    adminSidebarOverlay?.addEventListener('click', () => setAdminSidebarOpen(false));
    adminSidebar?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setAdminSidebarOpen(false)));
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => button.addEventListener('click', () => {
      shell.classList.toggle('dark');
      localStorage.setItem('admin.theme', shell.classList.contains('dark') ? 'dark' : 'light');
    }));
    document.querySelectorAll('[data-admin-search-toggle]').forEach((button) => button.addEventListener('click', () => {
      const form = button.closest('[data-admin-search-form]');
      form?.classList.add('is-open');
      form?.querySelector('[data-admin-search]')?.focus();
    }));
    document.addEventListener('click', (event) => {
      document.querySelectorAll('[data-admin-search-form].is-open').forEach((form) => {
        if (!form.contains(event.target) && !form.querySelector('[data-admin-search]')?.value) {
          form.classList.remove('is-open');
        }
      });
      document.querySelectorAll('.admin-notification-menu[open]').forEach((menu) => {
        if (!menu.contains(event.target)) menu.removeAttribute('open');
      });
    });
    document.addEventListener('keydown', (event) => {
      if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
        event.preventDefault();
        const search = document.querySelector('[data-admin-search]');
        search?.closest('[data-admin-search-form]')?.classList.add('is-open');
        search?.focus();
      }
      if (event.key === 'Escape') {
        setAdminSidebarOpen(false);
      }
    });
  }
});
