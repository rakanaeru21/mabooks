<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Service - {{ config('app.name', 'MaBooks') }}</title>

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
                <li><a href="{{ route('user.customer-service') }}" class="text-orange-500 font-semibold transition-colors">Customer Service</a></li>
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
            <a href="{{ route('user.customer-service') }}" class="block py-2 text-sm font-semibold text-orange-500">Customer Service</a>
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
    <section class="bg-white border-b border-gray-100 pt-24 pb-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <nav class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                        <a href="{{ route('user.dashboard') }}" class="hover:text-orange-500 transition-colors">Beranda</a>
                        <span>/</span>
                        <span class="text-gray-600 font-medium">Customer Service</span>
                    </nav>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Customer Service</h1>
                    <p class="text-gray-500 mt-1 text-sm">Kirim ulasan, keluhan, masukan, atau pertanyaan kepada kami.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
            <i class="fas fa-check-circle text-green-500 text-sm"></i>
            <span class="text-sm">{{ session('success') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Kirim Pesan -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-gray-200 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-1">Kirim Pesan</h2>
                    <p class="text-sm text-gray-400 mb-6">Isi formulir di bawah untuk mengirimkan pesan kepada tim kami.</p>

                    <form method="POST" action="{{ route('user.customer-service.store') }}" class="space-y-5">
                        @csrf

                        <!-- Tipe Pesan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Pesan</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="tipe" value="ulasan" class="peer sr-only" {{ old('tipe') == 'ulasan' ? 'checked' : '' }}>
                                    <div class="flex flex-col items-center gap-1.5 p-3 rounded-lg border border-gray-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:border-orange-300 transition-all">
                                        <span class="text-xs font-medium text-gray-600">Ulasan</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="tipe" value="keluhan" class="peer sr-only" {{ old('tipe') == 'keluhan' ? 'checked' : '' }}>
                                    <div class="flex flex-col items-center gap-1.5 p-3 rounded-lg border border-gray-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:border-orange-300 transition-all">
                                        <span class="text-xs font-medium text-gray-600">Keluhan</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="tipe" value="masukan" class="peer sr-only" {{ old('tipe') == 'masukan' ? 'checked' : '' }}>
                                    <div class="flex flex-col items-center gap-1.5 p-3 rounded-lg border border-gray-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:border-orange-300 transition-all">
                                        <span class="text-xs font-medium text-gray-600">Masukan</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="tipe" value="pertanyaan" class="peer sr-only" {{ old('tipe', 'pertanyaan') == 'pertanyaan' ? 'checked' : '' }}>
                                    <div class="flex flex-col items-center gap-1.5 p-3 rounded-lg border border-gray-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:border-orange-300 transition-all">
                                        <span class="text-xs font-medium text-gray-600">Pertanyaan</span>
                                    </div>
                                </label>
                            </div>
                            @error('tipe')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subjek -->
                        <div>
                            <label for="subjek" class="block text-sm font-semibold text-gray-700 mb-2">Subjek</label>
                            <input type="text" name="subjek" id="subjek" value="{{ old('subjek') }}" placeholder="Tulis subjek pesan..."
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-orange-400 transition-colors">
                            @error('subjek')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pesan -->
                        <div>
                            <label for="pesan" class="block text-sm font-semibold text-gray-700 mb-2">Pesan</label>
                            <textarea name="pesan" id="pesan" rows="6" placeholder="Tulis pesan kamu di sini..."
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-orange-400 transition-colors resize-none">{{ old('pesan') }}</textarea>
                            @error('pesan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-semibold py-2.5 px-6 rounded-lg transition-all text-sm">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Info Sidebar -->
            <div class="space-y-6">
                <!-- Kontak Info -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Informasi Kontak</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center justify-between py-1.5 border-b border-gray-50">
                            <span class="text-gray-400">Email</span>
                            <span class="text-gray-700 font-medium">cs@mabooks.id</span>
                        </li>
                        <li class="flex items-center justify-between py-1.5 border-b border-gray-50">
                            <span class="text-gray-400">Telepon</span>
                            <span class="text-gray-700 font-medium">+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center justify-between py-1.5">
                            <span class="text-gray-400">Jam Operasional</span>
                            <span class="text-gray-700 font-medium">Sen-Sab, 08:00-17:00</span>
                        </li>
                    </ul>
                </div>

                <!-- Tipe Pesan Info -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Jenis Pesan</h3>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <p class="font-medium text-gray-700">Ulasan</p>
                            <p class="text-xs text-gray-400">Berikan penilaian tentang buku atau layanan</p>
                        </li>
                        <li>
                            <p class="font-medium text-gray-700">Keluhan</p>
                            <p class="text-xs text-gray-400">Laporkan masalah yang kamu alami</p>
                        </li>
                        <li>
                            <p class="font-medium text-gray-700">Masukan</p>
                            <p class="text-xs text-gray-400">Saran untuk meningkatkan layanan kami</p>
                        </li>
                        <li>
                            <p class="font-medium text-gray-700">Pertanyaan</p>
                            <p class="text-xs text-gray-400">Tanyakan apa saja seputar MaBooks</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Riwayat Pesan -->
        <div class="mt-10">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-bold text-gray-900">Riwayat Pesan</h2>
                </div>

                @if($messages->count() > 0)
                <div class="divide-y divide-gray-50">
                    @foreach($messages as $msg)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $msg->subjek }}</h4>
                                    <span class="text-[10px] font-medium uppercase px-2 py-0.5 rounded
                                        @if($msg->tipe == 'ulasan') bg-yellow-100 text-yellow-700
                                        @elseif($msg->tipe == 'keluhan') bg-red-100 text-red-700
                                        @elseif($msg->tipe == 'masukan') bg-blue-100 text-blue-700
                                        @else bg-green-100 text-green-700
                                        @endif">{{ ucfirst($msg->tipe) }}</span>
                                    <span class="text-[10px] font-medium uppercase px-2 py-0.5 rounded
                                        {{ $msg->status == 'dibaca' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $msg->status == 'dibaca' ? 'Sudah Dibaca' : 'Belum Dibaca' }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 line-clamp-2">{{ $msg->pesan }}</p>
                                <p class="text-xs text-gray-400 mt-1.5">{{ $msg->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="px-6 py-4">
                    {{ $messages->links() }}
                </div>
                @else
                <div class="px-6 py-16 text-center">
                    <i class="fas fa-inbox text-3xl text-gray-200 mb-3 block"></i>
                    <p class="text-gray-400 text-sm font-medium">Belum ada pesan yang dikirim.</p>
                    <p class="text-gray-300 text-xs mt-1">Kirim pesan pertamamu menggunakan formulir di atas.</p>
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
                        <li><a href="/" class="text-gray-500 hover:text-gray-300 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('user.dashboard') }}" class="text-gray-500 hover:text-gray-300 transition-colors">Katalog Buku</a></li>
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

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const icon = menuBtn.querySelector('i');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-xmark');
        });
    </script>
</body>
</html>
