<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Buku - {{ config('app.name', 'MaBooks') }}</title>

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
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px -8px rgba(0, 0, 0, 0.1);
            border-color: #FDBA74;
        }
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
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
                <li><a href="{{ route('user.dashboard') }}" class="hover:text-orange-500 transition-colors">Beranda</a></li>
                <li><a href="{{ route('user.katalog') }}" class="text-orange-500 font-semibold transition-colors">Katalog</a></li>
                <li><a href="{{ route('user.orders') }}" class="hover:text-orange-500 transition-colors">Pesanan</a></li>
                <li><a href="{{ route('user.customer-service') }}" class="hover:text-orange-500 transition-colors">Customer Service</a></li>
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
            <a href="{{ route('user.dashboard') }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-500 transition-colors">Beranda</a>
            <a href="{{ route('user.katalog') }}" class="block py-2 text-sm font-semibold text-orange-500">Katalog</a>
            <a href="{{ route('user.orders') }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-500 transition-colors">Pesanan</a>
            <a href="{{ route('user.customer-service') }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-500 transition-colors">Customer Service</a>
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

    <!-- ==================== HERO ==================== -->
    <section class="bg-white border-b border-gray-100 pt-24 pb-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <nav class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                        <a href="{{ route('user.dashboard') }}" class="hover:text-orange-500 transition-colors">Beranda</a>
                        <span>/</span>
                        <span class="text-gray-600 font-medium">Katalog Buku</span>
                    </nav>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Katalog Buku</h1>
                    <p class="text-gray-500 mt-1 text-sm">Jelajahi seluruh koleksi buku berdasarkan kategori.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- ===== SIDEBAR KATEGORI ===== -->
            <aside class="lg:w-64 shrink-0">
                <div class="bg-white rounded-xl border border-gray-200 p-5 lg:sticky lg:top-28">
                    <h2 class="text-sm font-bold text-gray-900 mb-4">Kategori</h2>

                    <div class="space-y-1">
                        <a href="{{ route('user.katalog', request()->only('search')) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors
                           {{ !$activeCategory ? 'bg-orange-50 text-orange-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span>Semua Buku</span>
                            <span class="text-xs {{ !$activeCategory ? 'text-orange-400' : 'text-gray-400' }}">{{ $books->total() }}</span>
                        </a>

                        @foreach($categories as $cat)
                        <a href="{{ route('user.katalog', array_merge(request()->only('search'), ['category' => $cat->id])) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors
                           {{ $activeCategory == $cat->id ? 'bg-orange-50 text-orange-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span>{{ $cat->nama }}</span>
                            <span class="text-xs {{ $activeCategory == $cat->id ? 'text-orange-400' : 'text-gray-400' }}">{{ $cat->books_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </aside>

            <!-- ===== KONTEN BUKU ===== -->
            <div class="flex-1 min-w-0">
                <!-- Search Bar -->
                <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6 flex flex-col sm:flex-row items-center gap-3">
                    <form method="GET" action="{{ route('user.katalog') }}" class="flex-1 w-full flex items-center gap-3">
                        @if($activeCategory)
                        <input type="hidden" name="category" value="{{ $activeCategory }}">
                        @endif
                        <div class="relative flex-1">
                            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300 text-sm"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, atau penerbit..."
                                class="search-input w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-orange-400 transition-all">
                        </div>
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium text-sm px-5 py-2.5 rounded-lg transition-colors">
                            Cari
                        </button>
                        @if(request('search'))
                        <a href="{{ route('user.katalog', $activeCategory ? ['category' => $activeCategory] : []) }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-400 transition-colors shrink-0" title="Reset">
                            <i class="fas fa-times text-xs"></i>
                        </a>
                        @endif
                    </form>
                    <div class="flex items-center gap-2 text-sm text-gray-400 shrink-0">
                        <span><strong class="text-gray-700">{{ $books->total() }}</strong> buku</span>
                    </div>
                </div>

                @if(request('search'))
                <div class="mb-5 inline-flex items-center gap-2 bg-orange-50 text-orange-700 text-sm font-medium px-3 py-1.5 rounded-lg">
                    Hasil untuk "<strong>{{ request('search') }}</strong>" &mdash; {{ $books->total() }} ditemukan
                </div>
                @endif

                @php
                    $activeCategoryName = $activeCategory ? $categories->firstWhere('id', $activeCategory)?->nama : null;
                @endphp
                @if($activeCategoryName)
                <div class="mb-5 flex items-center gap-2">
                    <span class="text-sm text-gray-500">Kategori:</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $activeCategoryName }}</span>
                    <a href="{{ route('user.katalog', request()->only('search')) }}" class="text-xs text-gray-400 hover:text-red-500 ml-1 transition-colors">&times; Hapus filter</a>
                </div>
                @endif

                <!-- Book Grid -->
                @if($books->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach($books as $book)
                    <div class="bg-white rounded-xl overflow-hidden card-hover group border border-gray-200 cursor-pointer"
                         onclick="showBookDetail({
                            book_id: {{ $book->id }},
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
                        <div class="bg-gray-50 flex items-center justify-center h-52 relative overflow-hidden">
                            @if($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}" class="h-full w-full object-cover group-hover:scale-[1.03] transition-transform duration-300">
                            @else
                            <div class="flex flex-col items-center">
                                <i class="fas fa-book text-gray-200 text-5xl"></i>
                            </div>
                            @endif
                            @if($book->stok < 1)
                            <span class="absolute top-3 right-3 bg-red-500/90 text-white text-[10px] font-semibold px-2 py-0.5 rounded">Habis</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-0.5 line-clamp-1 text-sm">{{ $book->judul }}</h3>
                            <p class="text-xs text-gray-400 mb-1">{{ $book->penulis }}</p>
                            @if($book->category)
                            <p class="text-[11px] text-orange-500 font-medium mb-2">{{ $book->category->nama }}</p>
                            @endif
                            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                <p class="text-base font-bold text-gray-900">Rp {{ number_format($book->harga, 0, ',', '.') }}</p>
                                <span class="text-[11px] font-medium {{ $book->stok > 0 ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $book->stok > 0 ? 'Stok ' . $book->stok : 'Habis' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $books->withQueryString()->links() }}
                </div>
                @else
                <div class="text-center py-20 bg-white rounded-xl border border-gray-200">
                    <i class="fas fa-search text-4xl text-gray-200 mb-3 block"></i>
                    <p class="text-gray-400 text-base font-medium">
                        @if(request('search'))
                            Tidak ada buku yang cocok dengan pencarian "{{ request('search') }}".
                        @elseif($activeCategoryName)
                            Belum ada buku dalam kategori "{{ $activeCategoryName }}".
                        @else
                            Belum ada buku yang tersedia.
                        @endif
                    </p>
                    @if(request('search') || $activeCategory)
                    <a href="{{ route('user.katalog') }}" class="inline-block mt-3 text-orange-500 text-sm font-medium hover:text-orange-600 transition-colors">
                        Tampilkan semua buku
                    </a>
                    @endif
                </div>
                @endif
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
                        <li><a href="{{ route('user.dashboard') }}" class="text-gray-500 hover:text-gray-300 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('user.katalog') }}" class="text-gray-500 hover:text-gray-300 transition-colors">Katalog Buku</a></li>
                        <li><a href="{{ route('user.orders') }}" class="text-gray-500 hover:text-gray-300 transition-colors">Pesanan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Bantuan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('user.customer-service') }}" class="text-gray-500 hover:text-gray-300 transition-colors">Customer Service</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-300 transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2.5 text-sm text-gray-500">
                        <li>cs@mabooks.id</li>
                        <li>+62 812-3456-7890</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-10 pt-6">
                <p class="text-gray-600 text-xs text-center">&copy; {{ date('Y') }} MaBooks. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- ==================== FLOATING CART BUTTON ==================== -->
    <button id="cart-btn" onclick="toggleCart()" class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-gray-900 hover:bg-orange-500 active:scale-95 text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-200">
        <i class="fas fa-shopping-cart text-sm"></i>
        <span id="cart-count" class="absolute -top-1 -right-1 w-5 h-5 bg-orange-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center hidden">0</span>
    </button>

    <!-- ==================== CART SIDEBAR ==================== -->
    <div id="cart-overlay" class="hidden fixed inset-0 z-[55] bg-black/40 backdrop-blur-sm" onclick="toggleCart()"></div>
    <div id="cart-sidebar" class="fixed top-0 right-0 h-full w-full max-w-sm z-[56] bg-white shadow-2xl flex flex-col translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <h2 class="text-base font-bold text-gray-900">Keranjang</h2>
                <span id="cart-badge" class="text-xs font-medium text-gray-400">0 item</span>
            </div>
            <button onclick="toggleCart()" class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <div id="cart-items" class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
            <div id="cart-empty" class="flex flex-col items-center justify-center h-full py-16 text-center">
                <i class="fas fa-shopping-bag text-3xl text-gray-200 mb-3"></i>
                <p class="text-gray-400 text-sm font-medium">Keranjang masih kosong</p>
                <p class="text-gray-300 text-xs mt-1">Tambahkan buku untuk memulai.</p>
            </div>
        </div>
        <div id="cart-footer" class="hidden px-6 py-4 border-t border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm text-gray-500">Total</span>
                <span id="cart-total" class="text-lg font-bold text-gray-900">Rp 0</span>
            </div>
            <a href="{{ route('user.checkout') }}" class="w-full block text-center bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-semibold py-3 rounded-lg transition-all text-sm">
                Lanjut ke Pembayaran
            </a>
            <button onclick="clearCart()" class="w-full text-xs text-gray-400 hover:text-red-500 mt-2.5 transition-colors">
                Kosongkan Keranjang
            </button>
        </div>
    </div>

    <!-- ==================== BOOK DETAIL MODAL ==================== -->
    <div id="book-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeBookDetail()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden animate-modal">
            <button onclick="closeBookDetail()" class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/80 hover:bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
            <div class="flex flex-col sm:flex-row overflow-y-auto max-h-[90vh]">
                <div id="modal-cover-wrap" class="sm:w-2/5 shrink-0 bg-gray-50 flex items-center justify-center min-h-[240px] sm:min-h-[360px] relative">
                    <img id="modal-cover-img" src="" alt="" class="hidden h-full w-full object-cover">
                    <div id="modal-cover-placeholder" class="flex flex-col items-center">
                        <i class="fas fa-book text-gray-200 text-6xl"></i>
                    </div>
                </div>
                <div class="sm:w-3/5 p-6 sm:p-8 flex flex-col">
                    <div class="flex-1">
                        <h2 id="modal-judul" class="text-lg font-bold text-gray-900 mb-0.5 pr-8"></h2>
                        <p id="modal-penulis" class="text-sm text-gray-400 mb-4"></p>
                        <div class="flex items-center gap-3 mb-5">
                            <p id="modal-harga" class="text-xl font-bold text-gray-900"></p>
                            <span id="modal-stok" class="text-xs font-medium px-2 py-0.5 rounded"></span>
                        </div>
                        <div class="space-y-2.5 mb-5 text-sm">
                            <div class="flex items-center justify-between py-1.5 border-b border-gray-50">
                                <span class="text-gray-400">Penerbit</span>
                                <span id="modal-penerbit" class="text-gray-700 font-medium"></span>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-gray-50">
                                <span class="text-gray-400">Tahun Terbit</span>
                                <span id="modal-tahun" class="text-gray-700 font-medium"></span>
                            </div>
                            <div class="flex items-center justify-between py-1.5">
                                <span class="text-gray-400">ISBN</span>
                                <span id="modal-isbn" class="text-gray-700 font-medium"></span>
                            </div>
                        </div>
                        <div class="border-t border-gray-100 pt-4">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1.5">Deskripsi</p>
                            <p id="modal-deskripsi" class="text-sm text-gray-600 leading-relaxed"></p>
                        </div>
                    </div>
                    <div class="mt-5 flex gap-3">
                        <button id="modal-add-cart" onclick="addToCart()" class="flex-1 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-semibold py-2.5 rounded-lg transition-all text-sm">
                            Tambah ke Keranjang
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
                stokEl.className = 'text-xs font-medium px-2 py-0.5 rounded text-green-600 bg-green-50';
                document.getElementById('modal-add-cart').disabled = false;
                document.getElementById('modal-add-cart').className = 'flex-1 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-semibold py-2.5 rounded-lg transition-all text-sm';
            } else {
                stokEl.textContent = 'Habis';
                stokEl.className = 'text-xs font-medium px-2 py-0.5 rounded text-red-500 bg-red-50';
                document.getElementById('modal-add-cart').disabled = true;
                document.getElementById('modal-add-cart').className = 'flex-1 bg-gray-100 text-gray-400 font-semibold py-2.5 rounded-lg text-sm cursor-not-allowed';
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
        cart = cart.filter(i => i.book_id);
        localStorage.setItem('mabooks_cart', JSON.stringify(cart));
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
                cart.push({ book_id: currentBook.book_id, judul: currentBook.judul, penulis: currentBook.penulis, harga: currentBook.harga, hargaNum: parseInt(currentBook.harga.replace(/\D/g,'')), cover: currentBook.cover, stok: currentBook.stok, qty: 1 });
            }
            saveCart();
            closeBookDetail();
            renderCart();
            toggleCart();
        }

        function removeFromCart(idx) { cart.splice(idx, 1); saveCart(); renderCart(); }
        function changeQty(idx, delta) {
            cart[idx].qty += delta;
            if (cart[idx].qty <= 0) { removeFromCart(idx); return; }
            if (cart[idx].qty > cart[idx].stok) cart[idx].qty = cart[idx].stok;
            saveCart(); renderCart();
        }
        function clearCart() { cart = []; saveCart(); renderCart(); }
        function saveCart() { localStorage.setItem('mabooks_cart', JSON.stringify(cart)); }
        function formatRupiah(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

        function renderCart() {
            const count = cart.reduce((s, i) => s + i.qty, 0);
            const total = cart.reduce((s, i) => s + i.hargaNum * i.qty, 0);
            const countEl = document.getElementById('cart-count');
            countEl.textContent = count;
            countEl.classList.toggle('hidden', count === 0);
            document.getElementById('cart-badge').textContent = count + ' item';
            document.getElementById('cart-total').textContent = formatRupiah(total);

            const emptyEl = document.getElementById('cart-empty');
            const footerEl = document.getElementById('cart-footer');
            const itemsEl = document.getElementById('cart-items');

            if (cart.length === 0) {
                emptyEl.classList.remove('hidden');
                footerEl.classList.add('hidden');
                itemsEl.querySelectorAll('.cart-item-card').forEach(el => el.remove());
                return;
            }
            emptyEl.classList.add('hidden');
            footerEl.classList.remove('hidden');
            itemsEl.querySelectorAll('.cart-item-card').forEach(el => el.remove());
            cart.forEach((item, idx) => {
                const div = document.createElement('div');
                div.className = 'cart-item-card flex gap-3 bg-gray-50 rounded-xl p-3';
                div.innerHTML = `
                    <div class="w-12 h-16 shrink-0 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                        ${item.cover ? `<img src="${item.cover}" alt="" class="w-full h-full object-cover">` : `<i class="fas fa-book text-gray-300 text-lg"></i>`}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 line-clamp-1">${item.judul}</p>
                        <p class="text-xs text-gray-400">${item.penulis}</p>
                        <p class="text-sm font-bold text-gray-800 mt-1">${formatRupiah(item.hargaNum * item.qty)}</p>
                        <div class="flex items-center gap-2 mt-1.5">
                            <button onclick="changeQty(${idx}, -1)" class="w-6 h-6 bg-gray-200 hover:bg-gray-300 rounded flex items-center justify-center text-gray-600 transition-colors text-xs font-bold">−</button>
                            <span class="text-xs font-semibold w-4 text-center">${item.qty}</span>
                            <button onclick="changeQty(${idx}, 1)" class="w-6 h-6 bg-gray-200 hover:bg-gray-300 rounded flex items-center justify-center text-gray-600 transition-colors text-xs font-bold">+</button>
                            <button onclick="removeFromCart(${idx})" class="ml-auto w-6 h-6 hover:bg-red-50 rounded flex items-center justify-center text-gray-300 hover:text-red-400 transition-colors text-xs">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                `;
                itemsEl.appendChild(div);
            });
        }
        renderCart();
    </script>
</body>
</html>
