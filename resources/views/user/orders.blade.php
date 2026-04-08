<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Saya - {{ config('app.name', 'MaBooks') }}</title>

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

            <button id="menu-btn" class="md:hidden text-gray-900 text-xl focus:outline-none" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>

            <ul class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <li><a href="{{ route('user.dashboard') }}" class="hover:text-orange-500 transition-colors">Beranda</a></li>
                <li><a href="{{ route('user.katalog') }}" class="hover:text-orange-500 transition-colors">Katalog</a></li>
                <li><a href="{{ route('user.orders') }}" class="text-orange-500 font-semibold transition-colors">Pesanan</a></li>
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
            <a href="{{ route('user.katalog') }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-orange-500 transition-colors">Katalog</a>
            <a href="{{ route('user.orders') }}" class="block py-2 text-sm font-semibold text-orange-500">Pesanan</a>
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
                        <span class="text-gray-600 font-medium">Pesanan Saya</span>
                    </nav>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Pesanan Saya</h1>
                    <p class="text-gray-500 mt-1 text-sm">Pantau status pesanan dan riwayat belanjamu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        <!-- Filter Tabs -->
        <div class="bg-white rounded-xl border border-gray-200 p-1.5 mb-8 flex flex-wrap gap-1">
            @php
                $currentStatus = request('status');
                $filters = [
                    '' => 'Semua',
                    'pending' => 'Pending',
                    'diproses' => 'Diproses',
                    'dikirim' => 'Dikirim',
                    'selesai' => 'Selesai',
                    'dibatalkan' => 'Dibatalkan',
                ];
            @endphp
            @foreach($filters as $value => $label)
                <a href="{{ route('user.orders', $value ? ['status' => $value] : []) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                   {{ $currentStatus === ($value ?: null) ? 'bg-orange-500 text-white' : 'text-gray-500 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- Orders List -->
        @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <!-- Order Header -->
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-gray-900">Pesanan #{{ $order->id }}</span>
                        <span class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        @php
                            $statusConfig = [
                                'pending' => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-yellow-50 text-yellow-700'],
                                'diproses' => ['label' => 'Diproses', 'class' => 'bg-blue-50 text-blue-700'],
                                'dikirim' => ['label' => 'Dikirim', 'class' => 'bg-purple-50 text-purple-700'],
                                'selesai' => ['label' => 'Selesai', 'class' => 'bg-green-50 text-green-700'],
                                'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'bg-red-50 text-red-700'],
                            ];
                            $cfg = $statusConfig[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-100 text-gray-600'];
                        @endphp
                        <span class="text-xs font-medium px-2.5 py-1 rounded {{ $cfg['class'] }}">
                            {{ $cfg['label'] }}
                        </span>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="px-6 py-4">
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex gap-3">
                            <div class="w-12 h-16 shrink-0 rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center">
                                @if($item->book && $item->book->cover)
                                <img src="{{ asset('storage/' . $item->book->cover) }}" alt="" class="w-full h-full object-cover">
                                @else
                                <i class="fas fa-book text-gray-200 text-sm"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ $item->book->judul ?? 'Buku dihapus' }}</p>
                                <p class="text-xs text-gray-400">{{ $item->jumlah }}x @ Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-bold text-gray-800 shrink-0 self-center">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Footer -->
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="text-sm text-gray-400">
                        <span class="text-gray-500">Alamat:</span> {{ Str::limit($order->alamat, 50) }}
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-xs text-gray-400">Total</p>
                            <p class="text-base font-bold text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($order->status === 'pending' && !$order->bukti_pembayaran)
                            <a href="{{ route('user.payment', $order) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-medium text-xs px-4 py-2 rounded-lg transition-colors">
                                Bayar
                            </a>
                            @elseif($order->bukti_pembayaran)
                            <a href="{{ route('user.payment.success', $order) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium text-xs px-4 py-2 rounded-lg transition-colors">
                                Detail
                            </a>
                            @endif

                            @if($order->status === 'selesai')
                            <a href="{{ route('user.invoice', $order) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-medium text-xs px-4 py-2 rounded-lg transition-colors">
                                Invoice
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $orders->withQueryString()->links() }}
        </div>
        @else
        <div class="text-center py-20 bg-white rounded-xl border border-gray-200">
            <i class="fas fa-receipt text-4xl text-gray-200 mb-3 block"></i>
            <p class="text-gray-400 text-base font-medium">
                @if(request('status'))
                    Tidak ada pesanan dengan status "{{ $filters[request('status')] ?? request('status') }}".
                @else
                    Belum ada pesanan.
                @endif
            </p>
            @if(request('status'))
            <a href="{{ route('user.orders') }}" class="inline-block mt-3 text-orange-500 text-sm font-medium hover:text-orange-600 transition-colors">
                Tampilkan semua pesanan
            </a>
            @else
            <a href="{{ route('user.dashboard') }}" class="inline-block mt-3 text-orange-500 text-sm font-medium hover:text-orange-600 transition-colors">
                Mulai belanja
            </a>
            @endif
        </div>
        @endif
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
