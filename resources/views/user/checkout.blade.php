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
    <section class="bg-gradient-to-r from-orange-500 to-orange-600 pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white"><i class="fas fa-credit-card mr-3"></i>Checkout</h1>
                    <p class="text-orange-100 mt-2 text-sm md:text-base">Lengkapi alamat pengiriman untuk menyelesaikan pesanan.</p>
                </div>
                <div class="flex items-center gap-3 text-white text-sm">
                    <a href="{{ route('user.dashboard') }}" class="text-orange-200 hover:text-white transition-colors"><i class="fas fa-home mr-1"></i>Toko</a>
                    <i class="fas fa-chevron-right text-orange-300 text-xs"></i>
                    <span class="font-semibold">Checkout</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <!-- Empty Cart Warning -->
        <div id="empty-cart-warning" class="hidden text-center py-20 bg-white rounded-2xl border border-gray-100">
            <i class="fas fa-shopping-cart text-5xl text-gray-200 mb-4 block"></i>
            <p class="text-gray-400 text-lg font-medium">Keranjang kamu kosong!</p>
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 mt-4 bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm px-6 py-3 rounded-full transition-colors">
                <i class="fas fa-arrow-left text-xs"></i> Kembali Belanja
            </a>
        </div>

        <!-- Checkout Content -->
        <div id="checkout-content" class="hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Cart Items -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                            <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-orange-500 text-sm"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-gray-900">Pesanan Kamu</h2>
                                <p id="item-count-text" class="text-xs text-gray-400"></p>
                            </div>
                        </div>
                        <div id="checkout-items" class="divide-y divide-gray-50">
                            <!-- Items rendered by JS -->
                        </div>
                    </div>
                </div>

                <!-- Right: Address + Summary -->
                <div class="space-y-6">
                    <!-- Address Form -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-blue-500 text-sm"></i>
                            </div>
                            <h2 class="font-bold text-gray-900">Alamat Pengiriman</h2>
                        </div>
                        <div>
                            <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea id="alamat" rows="4" placeholder="Masukkan alamat lengkap pengiriman (nama jalan, RT/RW, kelurahan, kecamatan, kota, kode pos)..."
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors resize-none"></textarea>
                            <p id="alamat-error" class="hidden text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>Alamat wajib diisi.</p>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-receipt text-green-500 text-sm"></i>
                            </div>
                            <h2 class="font-bold text-gray-900">Ringkasan Pesanan</h2>
                        </div>
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
                                <span id="summary-total" class="text-xl font-extrabold text-orange-500">Rp 0</span>
                            </div>
                        </div>
                        <button id="btn-order" onclick="placeOrder()" class="w-full mt-6 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-bold py-3.5 rounded-2xl transition-all text-sm shadow-sm shadow-orange-500/30">
                            <i class="fas fa-check-circle mr-2"></i>Buat Pesanan
                        </button>
                        <a href="{{ route('user.dashboard') }}" class="block text-center mt-3 text-sm text-gray-400 hover:text-orange-500 transition-colors font-medium">
                            <i class="fas fa-arrow-left mr-1"></i>Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-gray-900 border-t border-gray-800 mt-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <div>
                    <a href="/" class="flex items-center gap-2 mb-4">
                        <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book-open text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-extrabold text-white">Ma<span class="text-orange-500">Books</span></span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Toko buku online terpercaya dengan koleksi terlengkap dan harga terjangkau untuk seluruh Indonesia.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="/" class="text-gray-500 hover:text-orange-500 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('user.dashboard') }}" class="text-gray-500 hover:text-orange-500 transition-colors">Katalog Buku</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Bantuan</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Cara Pemesanan</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Metode Pembayaran</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Pengiriman</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-orange-500 mt-0.5"></i>
                            <span class="text-gray-500">Jl. Pendidikan No. 123, Jakarta, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-orange-500"></i>
                            <span class="text-gray-500">+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-orange-500"></i>
                            <span class="text-gray-500">cs@mabooks.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-gray-600 text-sm">&copy; {{ date('Y') }} <span class="text-orange-500 font-semibold">MaBooks</span>. Semua hak dilindungi.</p>
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
                div.className = 'flex gap-4 px-6 py-4 hover:bg-gray-50 transition-colors';
                div.innerHTML = `
                    <div class="w-16 h-20 shrink-0 rounded-xl overflow-hidden bg-orange-50 flex items-center justify-center">
                        ${item.cover ? `<img src="${item.cover}" alt="" class="w-full h-full object-cover">` : `<i class="fas fa-book text-orange-200 text-2xl"></i>`}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-bold text-gray-900 line-clamp-1">${item.judul}</h3>
                        <p class="text-xs text-gray-400 mt-0.5">${item.penulis}</p>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full font-medium">${item.qty}x</span>
                                <span class="text-xs text-gray-400">@ ${item.harga}</span>
                            </div>
                            <p class="text-sm font-extrabold text-orange-500">${formatRupiah(item.hargaNum * item.qty)}</p>
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
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            btn.className = 'w-full mt-6 bg-gray-300 text-gray-500 font-bold py-3.5 rounded-2xl text-sm cursor-not-allowed';

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
                btn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Buat Pesanan';
                btn.className = 'w-full mt-6 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-bold py-3.5 rounded-2xl transition-all text-sm shadow-sm shadow-orange-500/30';
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
