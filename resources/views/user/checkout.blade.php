<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - {{ config('app.name', 'MaBooks') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: {
                            50: '#FFF7ED', 100: '#FFEDD5', 200: '#FED7AA', 300: '#FDBA74',
                            400: '#FB923C', 500: '#F97316', 600: '#EA580C',
                        }
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>html { scroll-behavior: smooth; overflow-x: hidden; }</style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- ==================== NAVBAR ==================== -->
    <nav class="bg-white/80 backdrop-blur-lg fixed top-0 left-0 right-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book-open text-white text-sm"></i>
                </div>
                <span class="text-xl font-extrabold text-gray-900">Ma<span class="text-orange-500">Books</span></span>
            </a>

            <ul class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <li><a href="{{ route('user.dashboard') }}" class="hover:text-orange-500 transition-colors">Beranda</a></li>
                <li><a href="{{ route('user.orders') }}" class="hover:text-orange-500 transition-colors">Pesanan</a></li>
                <li class="flex items-center gap-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                            {{ strtoupper(substr($user->nama, 0, 1)) }}
                        </div>
                        <span class="text-gray-700 font-semibold">{{ $user->nama }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-600 transition-colors font-semibold">
                            <i class="fas fa-sign-out-alt mr-1"></i>Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- ==================== HEADER ==================== -->
    <section class="bg-white border-b border-gray-100 pt-24 pb-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <nav class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                        <a href="{{ route('user.dashboard') }}" class="hover:text-orange-500 transition-colors">Beranda</a>
                        <span>/</span>
                        <span class="text-gray-600 font-medium">Checkout</span>
                    </nav>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Checkout</h1>
                    <p class="text-gray-500 mt-1 text-sm">Lengkapi alamat pengiriman untuk menyelesaikan pesanan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <!-- Empty Cart Warning -->
        <div id="empty-cart-warning" class="hidden text-center py-20 bg-white rounded-xl border border-gray-200">
            <i class="fas fa-shopping-bag text-4xl text-gray-200 mb-3 block"></i>
            <p class="text-gray-400 text-base font-medium">Keranjang kamu kosong</p>
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 mt-4 bg-orange-500 hover:bg-orange-600 text-white font-medium text-sm px-5 py-2.5 rounded-lg transition-colors">
                Kembali Belanja
            </a>
        </div>

        <!-- Checkout Content -->
        <div id="checkout-content" class="hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Cart Items -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                            <h2 class="font-bold text-gray-900">Pesanan Kamu</h2>
                            <span id="item-count-text" class="text-xs text-gray-400"></span>
                        </div>
                        <div id="checkout-items" class="divide-y divide-gray-50">
                            <!-- Items rendered by JS -->
                        </div>
                    </div>
                </div>

                <!-- Right: Address + Summary -->
                <div class="space-y-6">
                    <!-- Address Form -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h2 class="font-bold text-gray-900 mb-4">Alamat Pengiriman</h2>
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea id="alamat" rows="4" placeholder="Masukkan alamat lengkap pengiriman..."
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-orange-400 transition-colors resize-none"></textarea>
                            <p id="alamat-error" class="hidden text-xs text-red-500 mt-1">Alamat wajib diisi.</p>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h2 class="font-bold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Subtotal (<span id="summary-count">0</span> buku)</span>
                                <span id="summary-subtotal" class="font-semibold text-gray-900">Rp 0</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Ongkos Kirim</span>
                                <span class="font-semibold text-green-600">Gratis</span>
                            </div>
                            <div class="border-t border-gray-100 pt-3 flex items-center justify-between">
                                <span class="font-bold text-gray-900">Total</span>
                                <span id="summary-total" class="text-lg font-bold text-gray-900">Rp 0</span>
                            </div>
                        </div>
                        <button id="btn-order" onclick="placeOrder()" class="w-full mt-5 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-semibold py-3 rounded-lg transition-all text-sm">
                            Buat Pesanan
                        </button>
                        <a href="{{ route('user.dashboard') }}" class="block text-center mt-2.5 text-sm text-gray-400 hover:text-orange-500 transition-colors">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-gray-900 mt-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <div>
                    <a href="/" class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book-open text-white text-xs"></i>
                        </div>
                        <span class="text-lg font-bold text-white">Ma<span class="text-orange-400">Books</span></span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed">Toko buku online terpercaya dengan koleksi terlengkap dan harga terjangkau.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="text-gray-500 hover:text-gray-300 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('user.dashboard') }}" class="text-gray-500 hover:text-gray-300 transition-colors">Katalog Buku</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Bantuan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-500 hover:text-gray-300 transition-colors">Cara Pemesanan</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-300 transition-colors">Metode Pembayaran</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-300 transition-colors">Pengiriman</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2.5 text-sm text-gray-500">
                        <li>Jl. Pendidikan No. 123, Jakarta</li>
                        <li>+62 812-3456-7890</li>
                        <li>cs@mabooks.id</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-10 pt-6">
                <p class="text-gray-600 text-xs text-center">&copy; {{ date('Y') }} MaBooks. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        let cart = JSON.parse(localStorage.getItem('mabooks_cart') || '[]');

        // Remove items without book_id (old cart data)
        const invalidItems = cart.filter(i => !i.book_id);
        if (invalidItems.length > 0) {
            cart = cart.filter(i => i.book_id);
            localStorage.setItem('mabooks_cart', JSON.stringify(cart));
        }

        function formatRupiah(n) {
            return 'Rp ' + n.toLocaleString('id-ID');
        }

        function init() {
            if (cart.length === 0) {
                document.getElementById('empty-cart-warning').classList.remove('hidden');
                document.getElementById('checkout-content').classList.add('hidden');
                return;
            }

            document.getElementById('empty-cart-warning').classList.add('hidden');
            document.getElementById('checkout-content').classList.remove('hidden');

            const totalQty = cart.reduce((s, i) => s + i.qty, 0);
            const totalPrice = cart.reduce((s, i) => s + i.hargaNum * i.qty, 0);

            document.getElementById('item-count-text').textContent = totalQty + ' buku dalam keranjang';
            document.getElementById('summary-count').textContent = totalQty;
            document.getElementById('summary-subtotal').textContent = formatRupiah(totalPrice);
            document.getElementById('summary-total').textContent = formatRupiah(totalPrice);

            const container = document.getElementById('checkout-items');
            container.innerHTML = '';

            cart.forEach((item, idx) => {
                const div = document.createElement('div');
                div.className = 'flex gap-3 px-6 py-3 hover:bg-gray-50 transition-colors';
                div.innerHTML = `
                    <div class="w-12 h-16 shrink-0 rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center">
                        ${item.cover ? `<img src="${item.cover}" alt="" class="w-full h-full object-cover">` : `<i class="fas fa-book text-gray-200 text-lg"></i>`}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-900 line-clamp-1">${item.judul}</h3>
                        <p class="text-xs text-gray-400 mt-0.5">${item.penulis}</p>
                        <div class="flex items-center justify-between mt-1.5">
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded font-medium">${item.qty}x</span>
                                <span class="text-xs text-gray-400">@ ${item.harga}</span>
                            </div>
                            <p class="text-sm font-bold text-gray-900">${formatRupiah(item.hargaNum * item.qty)}</p>
                        </div>
                    </div>
                `;
                container.appendChild(div);
            });
        }

        function placeOrder() {
            const alamat = document.getElementById('alamat').value.trim();
            const errorEl = document.getElementById('alamat-error');
            const btn = document.getElementById('btn-order');

            if (!alamat) {
                errorEl.classList.remove('hidden');
                document.getElementById('alamat').focus();
                return;
            }
            errorEl.classList.add('hidden');

            // Disable button
            btn.disabled = true;
btn.innerHTML = 'Memproses...';
                btn.className = 'w-full mt-5 bg-gray-200 text-gray-400 font-semibold py-3 rounded-lg text-sm cursor-not-allowed';

            const items = cart.map(item => ({
                book_id: item.book_id,
                jumlah: item.qty,
            }));

            fetch('{{ route("user.checkout.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ alamat, items }),
            })
            .then(res => {
                if (!res.ok) return res.json().then(d => { throw d; });
                return res.json();
            })
            .then(data => {
                // Clear cart
                localStorage.removeItem('mabooks_cart');

                // Redirect to payment page
                window.location.href = '/payment/' + data.order_id;
            })
            .catch(err => {
                let msg = 'Terjadi kesalahan. Silakan coba lagi.';
                if (err.message) msg = err.message;
                if (err.errors) {
                    msg = Object.values(err.errors).flat().join('\n');
                }
                alert(msg);

                // Re-enable button
                btn.disabled = false;
                btn.innerHTML = 'Buat Pesanan';
                btn.className = 'w-full mt-5 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-semibold py-3 rounded-lg transition-all text-sm';
            });
        }

        // Hide error on typing
        document.getElementById('alamat').addEventListener('input', function() {
            document.getElementById('alamat-error').classList.add('hidden');
        });

        init();
    </script>

</body>
</html>
