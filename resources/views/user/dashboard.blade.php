<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - {{ config('app.name', 'MaBooks') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: {
                            50:  '#FFF7ED',
                            100: '#FFEDD5',
                            200: '#FED7AA',
                            300: '#FDBA74',
                            400: '#FB923C',
                            500: '#F97316',
                            600: '#EA580C',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        html { scroll-behavior: smooth; overflow-x: hidden; }
        body { overflow-x: hidden; max-width: 100vw; }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px -12px rgba(249, 115, 22, 0.15);
        }
    </style>
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

            <button id="menu-btn" class="md:hidden text-gray-900 text-xl focus:outline-none" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>

            <ul class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <li><a href="{{ route('user.dashboard') }}" class="text-orange-500 font-semibold transition-colors">Beranda</a></li>
                <li><a href="/#" class="hover:text-orange-500 transition-colors">Media</a></li>
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

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden px-6 pb-5 space-y-2 border-t border-gray-50 pt-3">
            <a href="/" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-500 transition-colors">Beranda</a>
            <a href="{{ route('user.dashboard') }}" class="block py-2 text-sm font-semibold text-orange-500">Toko</a>
            <a href="/#kategori" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-500 transition-colors">Kategori</a>
            <a href="/#tentang" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-500 transition-colors">Tentang</a>
            <div class="border-t border-gray-100 pt-3 mt-2">
                <div class="flex items-center gap-2 py-2">
                    <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    </div>
                    <span class="text-sm font-semibold text-gray-700">{{ $user->nama }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 text-sm font-medium text-red-500 hover:text-red-600 transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- ==================== HERO BANNER ==================== -->
    <section class="bg-gradient-to-r from-orange-500 to-orange-600 pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white">Selamat Datang, {{ $user->nama }}! 👋</h1>
                    <p class="text-orange-100 mt-2 text-sm md:text-base">Jelajahi semua koleksi buku terbaik kami. Temukan bacaan favoritmu!</p>
                </div>
                <div class="flex items-center gap-3 text-white text-sm">
                    <a href="/" class="text-orange-200 hover:text-white transition-colors"><i class="fas fa-home mr-1"></i>Beranda</a>
                    <i class="fas fa-chevron-right text-orange-300 text-xs"></i>
                    <span class="font-semibold">Toko</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-2xl border border-gray-100 p-5 mb-8 flex flex-col lg:flex-row items-center gap-4">
            <form method="GET" action="{{ route('user.dashboard') }}" class="flex-1 w-full flex items-center gap-3">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, atau penerbit..."
                        class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-full text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors">
                </div>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm px-6 py-3 rounded-full transition-colors shadow-sm shadow-orange-500/20">
                    <i class="fas fa-search mr-1"></i> Cari
                </button>
                @if(request('search'))
                <a href="{{ route('user.dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 hover:bg-gray-300 text-gray-500 transition-colors shrink-0" title="Reset">
                    <i class="fas fa-times text-sm"></i>
                </a>
                @endif
            </form>
            <div class="flex items-center gap-2 text-sm text-gray-500 shrink-0">
                <i class="fas fa-book text-orange-400"></i>
                <span><strong class="text-gray-900">{{ $books->total() }}</strong> buku tersedia</span>
            </div>
        </div>

        @if(request('search'))
        <div class="mb-6 inline-flex items-center gap-2 bg-orange-50 text-orange-700 text-sm font-medium px-4 py-2 rounded-full">
            <i class="fas fa-filter text-xs"></i>
            Hasil untuk "<strong>{{ request('search') }}</strong>" &mdash; {{ $books->total() }} buku ditemukan
        </div>
        @endif

        <!-- Book Grid -->
        @if($books->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($books as $book)
            <div class="bg-white rounded-2xl overflow-hidden card-hover group border border-gray-100 cursor-pointer"
                 onclick="showBookDetail({
                    judul: '{{ addslashes($book->judul) }}',
                    penulis: '{{ addslashes($book->penulis) }}',
                    penerbit: '{{ addslashes($book->penerbit ?? '-') }}',
                    tahun: '{{ $book->tahun_terbit ?? '-' }}',
                    isbn: '{{ $book->isbn ?? '-' }}',
                    harga: 'Rp {{ number_format($book->harga, 0, ',', '.') }}',
                    stok: {{ $book->stok }},
                    deskripsi: '{{ addslashes($book->deskripsi ?? 'Tidak ada deskripsi.') }}',
                    cover: '{{ $book->cover ? asset('storage/' . $book->cover) : '' }}'
                 })">
                <div class="bg-gradient-to-br from-orange-50 to-white flex items-center justify-center h-56 relative overflow-hidden">
                    @if($book->cover)
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="flex flex-col items-center gap-2">
                        <i class="fas fa-book text-orange-200 text-6xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    @endif
                    @if($book->stok < 1)
                    <span class="absolute top-3 right-3 bg-red-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">Habis</span>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 mb-1 line-clamp-1 text-[15px]">{{ $book->judul }}</h3>
                    <p class="text-xs text-gray-400 mb-3">{{ $book->penulis }}</p>
                    @if($book->penerbit)
                    <p class="text-[11px] text-gray-400 mb-3"><i class="fas fa-building mr-1"></i>{{ $book->penerbit }}</p>
                    @endif
                    <div class="flex items-center justify-between">
                        <p class="text-lg font-extrabold text-orange-500">Rp {{ number_format($book->harga, 0, ',', '.') }}</p>
                        <span class="text-[11px] font-semibold {{ $book->stok > 0 ? 'text-green-600 bg-green-50' : 'text-red-500 bg-red-50' }} px-2.5 py-1 rounded-full">
                            {{ $book->stok > 0 ? 'Stok ' . $book->stok : 'Habis' }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            {{ $books->withQueryString()->links() }}
        </div>
        @else
        <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
            <i class="fas fa-search text-5xl text-gray-200 mb-4 block"></i>
            <p class="text-gray-400 text-lg font-medium">
                @if(request('search'))
                    Tidak ada buku yang cocok dengan pencarian "{{ request('search') }}".
                @else
                    Belum ada buku yang tersedia.
                @endif
            </p>
            @if(request('search'))
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 mt-4 text-orange-500 font-semibold text-sm hover:text-orange-600 transition-colors">
                <i class="fas fa-arrow-left text-xs"></i> Tampilkan semua buku
            </a>
            @endif
        </div>
        @endif
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
                    <p class="text-gray-500 text-sm leading-relaxed mb-5">
                        Toko buku online terpercaya dengan koleksi terlengkap dan harga terjangkau untuk seluruh Indonesia.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-orange-500 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-colors text-sm"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-orange-500 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-colors text-sm"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-orange-500 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-colors text-sm"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-orange-500 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-colors text-sm"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="/" class="text-gray-500 hover:text-orange-500 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('user.dashboard') }}" class="text-gray-500 hover:text-orange-500 transition-colors">Katalog Buku</a></li>
                        <li><a href="/#kategori" class="text-gray-500 hover:text-orange-500 transition-colors">Kategori</a></li>
                        <li><a href="/#tentang" class="text-gray-500 hover:text-orange-500 transition-colors">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Bantuan</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Cara Pemesanan</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Metode Pembayaran</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Pengiriman</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">FAQ</a></li>
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
                <div class="flex items-center gap-4">
                    <span class="text-gray-600 text-xs">Metode Pembayaran:</span>
                    <div class="flex gap-2 text-gray-500 text-lg">
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fas fa-wallet"></i>
                        <i class="fas fa-university"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- ==================== FLOATING CART BUTTON ==================== -->
    <button id="cart-btn" onclick="toggleCart()" class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-orange-500 hover:bg-orange-600 active:scale-95 text-white rounded-full shadow-lg shadow-orange-500/40 flex items-center justify-center transition-all duration-200">
        <i class="fas fa-shopping-cart text-lg"></i>
        <span id="cart-count" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-[10px] font-extrabold rounded-full flex items-center justify-center hidden">0</span>
    </button>

    <!-- ==================== CART SIDEBAR ==================== -->
    <div id="cart-overlay" class="hidden fixed inset-0 z-[55] bg-black/40 backdrop-blur-sm" onclick="toggleCart()"></div>
    <div id="cart-sidebar" class="fixed top-0 right-0 h-full w-full max-w-sm z-[56] bg-white shadow-2xl flex flex-col translate-x-full transition-transform duration-300 ease-in-out">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-white text-sm"></i>
                </div>
                <h2 class="text-lg font-extrabold text-gray-900">Keranjang</h2>
                <span id="cart-badge" class="text-xs font-bold bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full">0 item</span>
            </div>
            <button onclick="toggleCart()" class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <!-- Cart Items -->
        <div id="cart-items" class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
            <!-- Empty state -->
            <div id="cart-empty" class="flex flex-col items-center justify-center h-full py-16 text-center">
                <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-shopping-cart text-3xl text-orange-200"></i>
                </div>
                <p class="text-gray-500 font-medium">Keranjang masih kosong</p>
                <p class="text-gray-400 text-sm mt-1">Tambahkan buku yang kamu suka!</p>
            </div>
        </div>

        <!-- Footer -->
        <div id="cart-footer" class="hidden px-6 py-5 border-t border-gray-100 bg-gray-50">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm text-gray-500 font-medium">Total</span>
                <span id="cart-total" class="text-xl font-extrabold text-orange-500">Rp 0</span>
            </div>
            <button class="w-full bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-bold py-3.5 rounded-2xl transition-all text-sm shadow-sm shadow-orange-500/30">
                <i class="fas fa-credit-card mr-2"></i>Lanjut ke Pembayaran
            </button>
            <button onclick="clearCart()" class="w-full text-sm text-gray-400 hover:text-red-500 mt-3 transition-colors font-medium">
                <i class="fas fa-trash-alt mr-1"></i>Kosongkan Keranjang
            </button>
        </div>
    </div>

    <!-- ==================== BOOK DETAIL MODAL ==================== -->
    <div id="book-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeBookDetail()"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden animate-modal">
            <button onclick="closeBookDetail()" class="absolute top-4 right-4 z-10 w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-sm"></i>
            </button>
            <div class="flex flex-col sm:flex-row overflow-y-auto max-h-[90vh]">
                <div id="modal-cover-wrap" class="sm:w-2/5 shrink-0 bg-gradient-to-br from-orange-50 to-white flex items-center justify-center min-h-[240px] sm:min-h-[360px] relative">
                    <img id="modal-cover-img" src="" alt="" class="hidden h-full w-full object-cover">
                    <div id="modal-cover-placeholder" class="flex flex-col items-center gap-2">
                        <i class="fas fa-book text-orange-200 text-7xl"></i>
                    </div>
                </div>
                <div class="sm:w-3/5 p-6 sm:p-8 flex flex-col">
                    <div class="flex-1">
                        <h2 id="modal-judul" class="text-xl font-extrabold text-gray-900 mb-1 pr-8"></h2>
                        <p id="modal-penulis" class="text-sm text-gray-500 mb-5"></p>
                        <div class="flex items-center gap-3 mb-6">
                            <p id="modal-harga" class="text-2xl font-extrabold text-orange-500"></p>
                            <span id="modal-stok" class="text-xs font-semibold px-3 py-1 rounded-full"></span>
                        </div>
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center shrink-0"><i class="fas fa-building text-gray-400 text-xs"></i></div>
                                <div>
                                    <p class="text-[11px] text-gray-400 uppercase tracking-wider">Penerbit</p>
                                    <p id="modal-penerbit" class="text-gray-700 font-medium"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center shrink-0"><i class="fas fa-calendar text-gray-400 text-xs"></i></div>
                                <div>
                                    <p class="text-[11px] text-gray-400 uppercase tracking-wider">Tahun Terbit</p>
                                    <p id="modal-tahun" class="text-gray-700 font-medium"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center shrink-0"><i class="fas fa-barcode text-gray-400 text-xs"></i></div>
                                <div>
                                    <p class="text-[11px] text-gray-400 uppercase tracking-wider">ISBN</p>
                                    <p id="modal-isbn" class="text-gray-700 font-medium"></p>
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-gray-100 pt-4">
                            <p class="text-[11px] text-gray-400 uppercase tracking-wider mb-2">Deskripsi</p>
                            <p id="modal-deskripsi" class="text-sm text-gray-600 leading-relaxed"></p>
                        </div>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button id="modal-add-cart" onclick="addToCart()" class="flex-1 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-bold py-3 rounded-xl transition-all text-sm shadow-sm shadow-orange-500/30">
                            <i class="fas fa-shopping-cart mr-2"></i>Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-modal { animation: modalIn 0.25s ease-out; }
    </style>

    <script>
        // Mobile menu
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const icon = menuBtn.querySelector('i');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-xmark');
        });

        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                icon.classList.add('fa-bars');
                icon.classList.remove('fa-xmark');
            });
        });

        // Book detail modal
        let currentBook = null;

        function showBookDetail(book) {
            currentBook = book;
            document.getElementById('modal-judul').textContent = book.judul;
            document.getElementById('modal-penulis').textContent = book.penulis;
            document.getElementById('modal-harga').textContent = book.harga;
            document.getElementById('modal-penerbit').textContent = book.penerbit;
            document.getElementById('modal-tahun').textContent = book.tahun;
            document.getElementById('modal-isbn').textContent = book.isbn;
            document.getElementById('modal-deskripsi').textContent = book.deskripsi;

            const img = document.getElementById('modal-cover-img');
            const placeholder = document.getElementById('modal-cover-placeholder');
            if (book.cover) {
                img.src = book.cover;
                img.alt = book.judul;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                img.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }

            const stokEl = document.getElementById('modal-stok');
            if (book.stok > 0) {
                stokEl.textContent = 'Stok ' + book.stok;
                stokEl.className = 'text-xs font-semibold px-3 py-1 rounded-full text-green-600 bg-green-50';
                document.getElementById('modal-add-cart').disabled = false;
                document.getElementById('modal-add-cart').className = 'flex-1 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-bold py-3 rounded-xl transition-all text-sm shadow-sm shadow-orange-500/30';
            } else {
                stokEl.textContent = 'Habis';
                stokEl.className = 'text-xs font-semibold px-3 py-1 rounded-full text-red-500 bg-red-50';
                document.getElementById('modal-add-cart').disabled = true;
                document.getElementById('modal-add-cart').className = 'flex-1 bg-gray-200 text-gray-400 font-bold py-3 rounded-xl text-sm cursor-not-allowed';
            }

            document.getElementById('book-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeBookDetail() {
            document.getElementById('book-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') { closeBookDetail(); closeCartIfOpen(); }
        });

        // ==================== CART ====================
        let cart = JSON.parse(localStorage.getItem('mabooks_cart') || '[]');
        let cartOpen = false;

        function toggleCart() {
            cartOpen = !cartOpen;
            const sidebar = document.getElementById('cart-sidebar');
            const overlay = document.getElementById('cart-overlay');
            if (cartOpen) {
                overlay.classList.remove('hidden');
                sidebar.classList.remove('translate-x-full');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        function closeCartIfOpen() {
            if (cartOpen) toggleCart();
        }

        function addToCart() {
            if (!currentBook || currentBook.stok < 1) return;
            const existing = cart.find(i => i.isbn === currentBook.isbn && i.judul === currentBook.judul);
            if (existing) {
                existing.qty = Math.min(existing.qty + 1, currentBook.stok);
            } else {
                cart.push({ judul: currentBook.judul, penulis: currentBook.penulis, harga: currentBook.harga, hargaNum: parseInt(currentBook.harga.replace(/\D/g,'')), cover: currentBook.cover, stok: currentBook.stok, qty: 1 });
            }
            saveCart();
            closeBookDetail();
            renderCart();
            toggleCart();
        }

        function removeFromCart(idx) {
            cart.splice(idx, 1);
            saveCart();
            renderCart();
        }

        function changeQty(idx, delta) {
            cart[idx].qty += delta;
            if (cart[idx].qty <= 0) { removeFromCart(idx); return; }
            if (cart[idx].qty > cart[idx].stok) cart[idx].qty = cart[idx].stok;
            saveCart();
            renderCart();
        }

        function clearCart() {
            cart = [];
            saveCart();
            renderCart();
        }

        function saveCart() {
            localStorage.setItem('mabooks_cart', JSON.stringify(cart));
        }

        function formatRupiah(n) {
            return 'Rp ' + n.toLocaleString('id-ID');
        }

        function renderCart() {
            const count = cart.reduce((s, i) => s + i.qty, 0);
            const total = cart.reduce((s, i) => s + i.hargaNum * i.qty, 0);

            // Badge on floating btn
            const countEl = document.getElementById('cart-count');
            countEl.textContent = count;
            countEl.classList.toggle('hidden', count === 0);

            // Badge in sidebar header
            document.getElementById('cart-badge').textContent = count + ' item';

            // Total
            document.getElementById('cart-total').textContent = formatRupiah(total);

            const emptyEl = document.getElementById('cart-empty');
            const footerEl = document.getElementById('cart-footer');
            const itemsEl = document.getElementById('cart-items');

            if (cart.length === 0) {
                emptyEl.classList.remove('hidden');
                footerEl.classList.add('hidden');
                // remove item cards
                itemsEl.querySelectorAll('.cart-item-card').forEach(el => el.remove());
                return;
            }

            emptyEl.classList.add('hidden');
            footerEl.classList.remove('hidden');

            // Re-render item cards
            itemsEl.querySelectorAll('.cart-item-card').forEach(el => el.remove());
            cart.forEach((item, idx) => {
                const div = document.createElement('div');
                div.className = 'cart-item-card flex gap-3 bg-gray-50 rounded-2xl p-3';
                div.innerHTML = `
                    <div class="w-14 h-18 shrink-0 rounded-xl overflow-hidden bg-orange-50 flex items-center justify-center">
                        ${item.cover ? `<img src="${item.cover}" alt="" class="w-full h-full object-cover">` : `<i class="fas fa-book text-orange-200 text-2xl"></i>`}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 line-clamp-1">${item.judul}</p>
                        <p class="text-xs text-gray-400 mb-2">${item.penulis}</p>
                        <p class="text-sm font-extrabold text-orange-500">${formatRupiah(item.hargaNum * item.qty)}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <button onclick="changeQty(${idx}, -1)" class="w-7 h-7 bg-gray-200 hover:bg-orange-500 hover:text-white rounded-full flex items-center justify-center text-gray-600 transition-colors text-sm font-bold">−</button>
                            <span class="text-sm font-bold w-5 text-center">${item.qty}</span>
                            <button onclick="changeQty(${idx}, 1)" class="w-7 h-7 bg-gray-200 hover:bg-orange-500 hover:text-white rounded-full flex items-center justify-center text-gray-600 transition-colors text-sm font-bold">+</button>
                            <button onclick="removeFromCart(${idx})" class="ml-auto w-7 h-7 bg-red-50 hover:bg-red-500 hover:text-white rounded-full flex items-center justify-center text-red-400 transition-colors text-xs">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                `;
                itemsEl.appendChild(div);
            });
        }

        // Init cart
        renderCart();
    </script>

</body>
</html>
