<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MaBooks') }} - Toko Buku Online Terpercaya</title>

    <!-- Tailwind CSS CDN -->
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

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
        }
        body {
            overflow-x: hidden;
            max-width: 100vw;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #FFF7ED 0%, #FFFFFF 50%, #FFEDD5 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px -12px rgba(249, 115, 22, 0.15);
        }
        .book-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .badge-pulse {
            animation: pulse-ring 2s ease-out infinite;
        }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.4); }
            70% { box-shadow: 0 0 0 12px rgba(249, 115, 22, 0); }
            100% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0); }
        }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans antialiased">

    <!-- ==================== NAVBAR ==================== -->
    <nav class="bg-white/80 backdrop-blur-lg fixed top-0 left-0 right-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="#" class="flex items-center gap-2">
                <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book-open text-white text-sm"></i>
                </div>
                <span class="text-xl font-extrabold text-gray-900">Ma<span class="text-orange-500">Books</span></span>
            </a>

            <!-- Mobile Menu Button -->
            <button id="menu-btn" class="md:hidden text-gray-900 text-xl focus:outline-none" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Desktop Menu -->
            <ul class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <li><a href="#hero" class="hover:text-orange-500 transition-colors">Beranda</a></li>
                <li><a href="#kategori" class="hover:text-orange-500 transition-colors">Kategori</a></li>
                <li><a href="#keunggulan" class="hover:text-orange-500 transition-colors">Keunggulan</a></li>
                <li><a href="#tentang" class="hover:text-orange-500 transition-colors">Tentang</a></li>
                <li><a href="#" class="text-gray-900 hover:text-orange-500 transition-colors"><i class="fas fa-shopping-cart mr-1"></i>Keranjang</a></li>
                @auth
                <li class="flex items-center gap-3">
                    <span class="text-gray-700 font-semibold"><i class="fas fa-user-circle mr-1"></i>{{ Auth::user()->nama }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-600 transition-colors font-semibold">
                            <i class="fas fa-sign-out-alt mr-1"></i>Keluar
                        </button>
                    </form>
                </li>
                @else
                <li><a href="{{ route('login') }}" class="text-gray-900 hover:text-orange-500 transition-colors font-semibold"><i class="fas fa-sign-in-alt mr-1"></i>Masuk</a></li>
                <li>
                    <a href="{{ route('register') }}" class="bg-orange-500 text-white px-6 py-2.5 rounded-full hover:bg-orange-600 transition-colors font-semibold shadow-lg shadow-orange-500/25">
                        Daftar
                    </a>
                </li>
                @endauth
            </ul>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden px-6 pb-5 space-y-2 border-t border-gray-50 pt-3">
            <a href="#hero" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-500 transition-colors">Beranda</a>
            <a href="#kategori" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-500 transition-colors">Kategori</a>
            <a href="#keunggulan" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-500 transition-colors">Keunggulan</a>
            <a href="#tentang" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-500 transition-colors">Tentang</a>
            <a href="#" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-500 transition-colors"><i class="fas fa-shopping-cart mr-1"></i>Keranjang</a>
            @auth
            <div class="border-t border-gray-100 pt-3 mt-2">
                <p class="text-sm font-semibold text-gray-700 py-2"><i class="fas fa-user-circle mr-1"></i>{{ Auth::user()->nama }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 text-sm font-medium text-red-500 hover:text-red-600 transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i>Keluar
                    </button>
                </form>
            </div>
            @else
            <a href="{{ route('login') }}" class="block py-2 text-sm font-medium text-gray-900 hover:text-orange-500 transition-colors"><i class="fas fa-sign-in-alt mr-1"></i>Masuk</a>
            <a href="{{ route('register') }}" class="block bg-orange-500 text-white text-sm font-semibold text-center px-5 py-3 rounded-full hover:bg-orange-600 transition-colors mt-2">
                Daftar
            </a>
            @endauth
        </div>
    </nav>

    <!-- ==================== HERO SECTION ==================== -->
    <section id="hero" class="hero-gradient overflow-hidden pt-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 md:py-28 lg:py-32 flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            <!-- Text Content -->
            <div class="lg:w-1/2 text-center lg:text-left">
                <span class="inline-flex items-center gap-2 bg-orange-100 text-orange-600 text-xs font-semibold px-4 py-1.5 rounded-full mb-6 uppercase tracking-wider">
                    <i class="fas fa-fire"></i> Promo Spesial Bulan Ini
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight">
                    Temukan Buku <br class="hidden sm:block" />
                    <span class="text-orange-500">Favoritmu</span> di Sini
                </h1>
                <p class="mt-5 text-lg text-gray-500 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                    MaBooks adalah toko buku online terlengkap dengan ribuan judul dari berbagai genre. Harga terjangkau, pengiriman cepat ke seluruh Indonesia.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#kategori" class="bg-orange-500 text-white font-semibold px-8 py-4 rounded-full text-base hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/30 inline-flex items-center justify-center gap-2">
                        <i class="fas fa-shopping-bag"></i> Mulai Belanja
                    </a>
                    <a href="#keunggulan" class="border-2 border-gray-200 text-gray-700 font-semibold px-8 py-4 rounded-full text-base hover:border-orange-500 hover:text-orange-500 transition-colors inline-flex items-center justify-center gap-2">
                        <i class="fas fa-play-circle"></i> Kenapa MaBooks?
                    </a>
                </div>
                <!-- Trust badges -->
                <div class="mt-10 flex items-center gap-6 justify-center lg:justify-start text-gray-400 text-sm">
                    <span class="flex items-center gap-1.5"><i class="fas fa-star text-orange-400"></i> <strong class="text-gray-700">4.9</strong>/5 Rating</span>
                    <span class="w-px h-4 bg-gray-200"></span>
                    <span class="flex items-center gap-1.5"><i class="fas fa-users text-orange-400"></i> <strong class="text-gray-700">50K+</strong> Pembeli</span>
                    <span class="w-px h-4 bg-gray-200 hidden sm:block"></span>
                    <span class="hidden sm:flex items-center gap-1.5"><i class="fas fa-book text-orange-400"></i> <strong class="text-gray-700">100K+</strong> Buku</span>
                </div>
            </div>

            <!-- Hero Visual -->
            <div class="lg:w-1/2 flex justify-center relative">
                <div class="relative book-float">
                    <div class="w-72 h-80 md:w-80 md:h-96 bg-gradient-to-br from-orange-400 to-orange-600 rounded-3xl flex flex-col items-center justify-center shadow-2xl shadow-orange-500/20 relative overflow-hidden">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-6 left-6 text-6xl text-white"><i class="fas fa-quote-left"></i></div>
                            <div class="absolute bottom-6 right-6 text-6xl text-white"><i class="fas fa-quote-right"></i></div>
                        </div>
                        <i class="fas fa-book text-white text-7xl mb-4 relative z-10"></i>
                        <p class="text-white font-bold text-xl relative z-10">MaBooks</p>
                        <p class="text-orange-100 text-sm relative z-10">Toko Buku Online</p>
                    </div>
                    <!-- Floating badge -->
                    <div class="absolute -top-4 -right-4 bg-white rounded-2xl shadow-xl px-4 py-3 flex items-center gap-3 badge-pulse">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-truck-fast text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900">Gratis Ongkir</p>
                            <p class="text-[11px] text-gray-400">Min. belanja 100rb</p>
                        </div>
                    </div>
                    <!-- Floating badge bottom -->
                    <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl shadow-xl px-4 py-3 flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-percent text-orange-600"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900">Diskon 30%</p>
                            <p class="text-[11px] text-gray-400">Buku pilihan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== KATEGORI SECTION ==================== -->
    <section id="kategori" class="bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 md:py-28">
            <div class="text-center mb-14">
                <span class="text-orange-500 font-semibold text-sm uppercase tracking-wider">Jelajahi Koleksi</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2">Kategori <span class="text-orange-500">Populer</span></h2>
                <p class="mt-4 text-gray-500 max-w-xl mx-auto">
                    Temukan buku dari berbagai kategori sesuai minat dan kebutuhanmu.
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-5">
                <!-- Kategori Items -->
                <a href="#" class="group bg-orange-50 hover:bg-orange-500 rounded-2xl p-6 text-center transition-all duration-300 card-hover">
                    <div class="w-14 h-14 bg-orange-100 group-hover:bg-white/20 text-orange-500 group-hover:text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl transition-colors duration-300">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 group-hover:text-white transition-colors duration-300">Novel</h3>
                </a>

                <a href="#" class="group bg-orange-50 hover:bg-orange-500 rounded-2xl p-6 text-center transition-all duration-300 card-hover">
                    <div class="w-14 h-14 bg-orange-100 group-hover:bg-white/20 text-orange-500 group-hover:text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl transition-colors duration-300">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 group-hover:text-white transition-colors duration-300">Sains</h3>
                </a>

                <a href="#" class="group bg-orange-50 hover:bg-orange-500 rounded-2xl p-6 text-center transition-all duration-300 card-hover">
                    <div class="w-14 h-14 bg-orange-100 group-hover:bg-white/20 text-orange-500 group-hover:text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl transition-colors duration-300">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 group-hover:text-white transition-colors duration-300">Bisnis</h3>
                </a>

                <a href="#" class="group bg-orange-50 hover:bg-orange-500 rounded-2xl p-6 text-center transition-all duration-300 card-hover">
                    <div class="w-14 h-14 bg-orange-100 group-hover:bg-white/20 text-orange-500 group-hover:text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl transition-colors duration-300">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 group-hover:text-white transition-colors duration-300">Edukasi</h3>
                </a>

                <a href="#" class="group bg-orange-50 hover:bg-orange-500 rounded-2xl p-6 text-center transition-all duration-300 card-hover">
                    <div class="w-14 h-14 bg-orange-100 group-hover:bg-white/20 text-orange-500 group-hover:text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl transition-colors duration-300">
                        <i class="fas fa-child"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 group-hover:text-white transition-colors duration-300">Anak-Anak</h3>
                </a>

                <a href="#" class="group bg-orange-50 hover:bg-orange-500 rounded-2xl p-6 text-center transition-all duration-300 card-hover">
                    <div class="w-14 h-14 bg-orange-100 group-hover:bg-white/20 text-orange-500 group-hover:text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl transition-colors duration-300">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 group-hover:text-white transition-colors duration-300">Religi</h3>
                </a>
            </div>
        </div>
    </section>

    <!-- ==================== BUKU POPULER SECTION ==================== -->
    <section class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 md:py-28">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-14 gap-4">
                <div>
                    <span class="text-orange-500 font-semibold text-sm uppercase tracking-wider">Best Seller</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2">Buku <span class="text-orange-500">Terlaris</span></h2>
                </div>
                <a href="#" class="text-orange-500 font-semibold text-sm hover:text-orange-600 transition-colors inline-flex items-center gap-1.5">
                    Lihat Semua <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Buku 1 -->
                <div class="bg-white rounded-2xl overflow-hidden card-hover group">
                    <div class="bg-gradient-to-br from-orange-100 to-orange-50 p-8 flex items-center justify-center h-56 relative">
                        <i class="fas fa-book text-orange-300 text-7xl group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="absolute top-4 left-4 bg-orange-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">Baru</span>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-orange-500 font-semibold mb-1">Novel</p>
                        <h3 class="font-bold text-gray-900 mb-1 line-clamp-1">Laut Bercerita</h3>
                        <p class="text-xs text-gray-400 mb-3">Leila S. Chudori</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-400 line-through">Rp 98.000</p>
                                <p class="text-lg font-extrabold text-gray-900">Rp 75.000</p>
                            </div>
                            <button class="w-10 h-10 bg-orange-500 hover:bg-orange-600 text-white rounded-full flex items-center justify-center transition-colors">
                                <i class="fas fa-cart-plus text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Buku 2 -->
                <div class="bg-white rounded-2xl overflow-hidden card-hover group">
                    <div class="bg-gradient-to-br from-orange-100 to-orange-50 p-8 flex items-center justify-center h-56 relative">
                        <i class="fas fa-book text-orange-300 text-7xl group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">-30%</span>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-orange-500 font-semibold mb-1">Bisnis</p>
                        <h3 class="font-bold text-gray-900 mb-1 line-clamp-1">Atomic Habits</h3>
                        <p class="text-xs text-gray-400 mb-3">James Clear</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-400 line-through">Rp 120.000</p>
                                <p class="text-lg font-extrabold text-gray-900">Rp 84.000</p>
                            </div>
                            <button class="w-10 h-10 bg-orange-500 hover:bg-orange-600 text-white rounded-full flex items-center justify-center transition-colors">
                                <i class="fas fa-cart-plus text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Buku 3 -->
                <div class="bg-white rounded-2xl overflow-hidden card-hover group">
                    <div class="bg-gradient-to-br from-orange-100 to-orange-50 p-8 flex items-center justify-center h-56 relative">
                        <i class="fas fa-book text-orange-300 text-7xl group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="absolute top-4 left-4 bg-orange-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">Populer</span>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-orange-500 font-semibold mb-1">Sains</p>
                        <h3 class="font-bold text-gray-900 mb-1 line-clamp-1">Sapiens</h3>
                        <p class="text-xs text-gray-400 mb-3">Yuval N. Harari</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-400 line-through">Rp 135.000</p>
                                <p class="text-lg font-extrabold text-gray-900">Rp 99.000</p>
                            </div>
                            <button class="w-10 h-10 bg-orange-500 hover:bg-orange-600 text-white rounded-full flex items-center justify-center transition-colors">
                                <i class="fas fa-cart-plus text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Buku 4 -->
                <div class="bg-white rounded-2xl overflow-hidden card-hover group">
                    <div class="bg-gradient-to-br from-orange-100 to-orange-50 p-8 flex items-center justify-center h-56 relative">
                        <i class="fas fa-book text-orange-300 text-7xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-orange-500 font-semibold mb-1">Edukasi</p>
                        <h3 class="font-bold text-gray-900 mb-1 line-clamp-1">Filosofi Teras</h3>
                        <p class="text-xs text-gray-400 mb-3">Henry Manampiring</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-400 line-through">Rp 95.000</p>
                                <p class="text-lg font-extrabold text-gray-900">Rp 69.000</p>
                            </div>
                            <button class="w-10 h-10 bg-orange-500 hover:bg-orange-600 text-white rounded-full flex items-center justify-center transition-colors">
                                <i class="fas fa-cart-plus text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== KEUNGGULAN SECTION ==================== -->
    <section id="keunggulan" class="bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 md:py-28">
            <div class="text-center mb-14">
                <span class="text-orange-500 font-semibold text-sm uppercase tracking-wider">Kenapa Kami?</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2">Keunggulan <span class="text-orange-500">MaBooks</span></h2>
                <p class="mt-4 text-gray-500 max-w-xl mx-auto">
                    Belanja buku jadi lebih mudah, murah, dan menyenangkan bersama MaBooks.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Keunggulan 1 -->
                <div class="text-center card-hover bg-white border border-gray-100 rounded-2xl p-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-5 text-2xl shadow-lg shadow-orange-500/20">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-2">Koleksi Terlengkap</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Lebih dari 100.000 judul buku dari penerbit lokal dan internasional.</p>
                </div>

                <!-- Keunggulan 2 -->
                <div class="text-center card-hover bg-white border border-gray-100 rounded-2xl p-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-5 text-2xl shadow-lg shadow-orange-500/20">
                        <i class="fas fa-truck-fast"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-2">Pengiriman Cepat</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Kirim ke seluruh Indonesia dengan estimasi 1-3 hari kerja.</p>
                </div>

                <!-- Keunggulan 3 -->
                <div class="text-center card-hover bg-white border border-gray-100 rounded-2xl p-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-5 text-2xl shadow-lg shadow-orange-500/20">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-2">Pembayaran Aman</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Dukung berbagai metode pembayaran dengan jaminan keamanan penuh.</p>
                </div>

                <!-- Keunggulan 4 -->
                <div class="text-center card-hover bg-white border border-gray-100 rounded-2xl p-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-5 text-2xl shadow-lg shadow-orange-500/20">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-2">Harga Terjangkau</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Diskon hingga 50% dan promo menarik setiap bulan untuk semua buku.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== TENTANG SECTION ==================== -->
    <section id="tentang" class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 md:py-28 flex flex-col lg:flex-row items-center gap-16">
            <!-- Visual -->
            <div class="lg:w-1/2 flex justify-center">
                <div class="relative">
                    <div class="w-full max-w-md bg-gradient-to-br from-orange-400 to-orange-600 rounded-3xl p-10 flex flex-col items-center justify-center aspect-square shadow-2xl shadow-orange-500/15">
                        <i class="fas fa-store text-white text-8xl mb-6 opacity-80"></i>
                        <p class="text-white text-2xl font-extrabold">MaBooks</p>
                        <p class="text-orange-100 text-sm mt-1">Sejak 2024</p>
                        <div class="flex gap-6 mt-8">
                            <div class="text-center">
                                <p class="text-white text-2xl font-extrabold">100K+</p>
                                <p class="text-orange-100 text-xs">Buku</p>
                            </div>
                            <div class="w-px bg-white/20"></div>
                            <div class="text-center">
                                <p class="text-white text-2xl font-extrabold">50K+</p>
                                <p class="text-orange-100 text-xs">Pembeli</p>
                            </div>
                            <div class="w-px bg-white/20"></div>
                            <div class="text-center">
                                <p class="text-white text-2xl font-extrabold">4.9</p>
                                <p class="text-orange-100 text-xs">Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Text -->
            <div class="lg:w-1/2">
                <span class="text-orange-500 font-semibold text-sm uppercase tracking-wider">Tentang Kami</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2 mb-6">
                    Toko Buku Online <span class="text-orange-500">Terpercaya</span>
                </h2>
                <p class="text-gray-500 leading-relaxed mb-6">
                    MaBooks hadir untuk memudahkan kamu menemukan dan membeli buku berkualitas dari mana saja. Kami bekerja sama dengan ratusan penerbit dan distributor resmi untuk memastikan setiap buku yang kamu terima adalah original dan berkualitas.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center mt-0.5 shrink-0">
                            <i class="fas fa-check text-orange-500 text-xs"></i>
                        </div>
                        <span class="text-gray-600">100% buku original dari penerbit resmi</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center mt-0.5 shrink-0">
                            <i class="fas fa-check text-orange-500 text-xs"></i>
                        </div>
                        <span class="text-gray-600">Gratis ongkir untuk pembelian di atas Rp 100.000</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center mt-0.5 shrink-0">
                            <i class="fas fa-check text-orange-500 text-xs"></i>
                        </div>
                        <span class="text-gray-600">Garansi tukar buku jika ada kerusakan pengiriman</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center mt-0.5 shrink-0">
                            <i class="fas fa-check text-orange-500 text-xs"></i>
                        </div>
                        <span class="text-gray-600">Customer service responsif 24/7</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ==================== CTA / NEWSLETTER SECTION ==================== -->
    <section id="cta" class="bg-gray-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-orange-500 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-orange-500 rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 md:py-28 text-center relative z-10">
            <span class="text-orange-400 font-semibold text-sm uppercase tracking-wider">Jangan Lewatkan</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mt-3 mb-4">Siap Menemukan Buku Impianmu?</h2>
            <p class="text-gray-400 max-w-xl mx-auto mb-10 leading-relaxed">
                Bergabung dengan 50.000+ pecinta buku yang sudah berbelanja di MaBooks. Daftar sekarang dan dapatkan voucher diskon 20% untuk pembelian pertama!
            </p>
            <div class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input type="email" placeholder="Masukkan email kamu..." class="flex-1 px-5 py-4 rounded-full bg-gray-800 border border-gray-700 text-white placeholder-gray-500 focus:outline-none focus:border-orange-500 transition-colors text-sm">
                <button class="bg-orange-500 text-white font-semibold px-8 py-4 rounded-full hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/30 whitespace-nowrap text-sm">
                    <i class="fas fa-paper-plane mr-2"></i>Daftar Gratis
                </button>
            </div>
            <p class="text-gray-600 text-xs mt-4">Kami tidak akan mengirim spam. Berhenti kapan saja.</p>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-gray-900 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Brand -->
                <div>
                    <a href="#" class="flex items-center gap-2 mb-4">
                        <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book-open text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-extrabold text-white">Ma<span class="text-orange-500">Books</span></span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed mb-5">
                        Toko buku online terpercaya dengan koleksi terlengkap dan harga terjangkau untuk seluruh Indonesia.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-orange-500 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-colors text-sm">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-orange-500 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-colors text-sm">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-orange-500 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-colors text-sm">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-orange-500 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-colors text-sm">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigasi -->
                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Beranda</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Katalog Buku</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Promo</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Blog</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Tentang Kami</a></li>
                    </ul>
                </div>

                <!-- Bantuan -->
                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Bantuan</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Cara Pemesanan</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Metode Pembayaran</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Pengiriman</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Pengembalian</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
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

            <!-- Copyright -->
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-gray-600 text-sm">
                    &copy; {{ date('Y') }} <span class="text-orange-500 font-semibold">MaBooks</span>. Semua hak dilindungi.
                </p>
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

    <!-- ==================== MOBILE MENU SCRIPT ==================== -->
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const icon = menuBtn.querySelector('i');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-xmark');
        });

        // Close mobile menu on link click
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                icon.classList.add('fa-bars');
                icon.classList.remove('fa-xmark');
            });
        });
    </script>

</body>
</html>
