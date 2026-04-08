<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Berhasil - {{ config('app.name', 'MaBooks') }}</title>

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
    <style>
        html { scroll-behavior: smooth; overflow-x: hidden; }
        @keyframes checkIn { from { opacity: 0; transform: scale(0.5); } to { opacity: 1; transform: scale(1); } }
        .animate-check { animation: checkIn 0.4s ease-out; }
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
            <ul class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <li><a href="{{ route('user.dashboard') }}" class="hover:text-orange-500 transition-colors">Beranda</a></li>
                <li><a href="{{ route('user.katalog') }}" class="hover:text-orange-500 transition-colors">Katalog</a></li>
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

    <!-- ==================== MAIN ==================== -->
    <main class="max-w-3xl mx-auto px-6 lg:px-8 pt-28 pb-16">
        <!-- Success Card -->
        <div class="bg-white rounded-xl border border-gray-200 p-8 md:p-12 text-center mb-8">
            <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-5 animate-check">
                <i class="fas fa-check text-2xl text-green-500"></i>
            </div>
            <h1 class="text-xl md:text-2xl font-bold text-gray-900 mb-2">Pembayaran Terkirim</h1>
            <p class="text-gray-500 text-sm mb-1">Bukti pembayaran kamu telah berhasil dikirim.</p>
            <p class="text-xs text-gray-400">Pesanan akan segera diproses oleh admin.</p>

            <div class="mt-6 inline-flex items-center gap-1.5 bg-gray-50 text-gray-700 font-bold text-base px-5 py-2.5 rounded-lg">
                Pesanan #{{ $order->id }}
            </div>
        </div>

        <!-- Order Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Items -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="font-bold text-gray-900 mb-4">Buku Dipesan</h2>
                <div class="space-y-3">
                    @foreach ($order->items as $item)
                    <div class="flex gap-3">
                        <div class="w-10 h-14 shrink-0 rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center">
                            @if ($item->book && $item->book->cover)
                            <img src="{{ asset('storage/' . $item->book->cover) }}" alt="" class="w-full h-full object-cover">
                            @else
                            <i class="fas fa-book text-gray-200 text-xs"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 line-clamp-1">{{ $item->book->judul ?? 'Buku dihapus' }}</p>
                            <p class="text-xs text-gray-400">{{ $item->jumlah }}x @ Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-sm font-bold text-gray-800 shrink-0">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-100 mt-4 pt-4 flex items-center justify-between">
                    <span class="font-bold text-gray-900">Total</span>
                    <span class="text-lg font-bold text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Info -->
            <div class="space-y-6">
                <!-- Alamat -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="font-bold text-gray-900 mb-3">Alamat Pengiriman</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $order->alamat }}</p>
                </div>

                <!-- Status -->
                <div class="bg-green-50 rounded-xl border border-green-100 p-4">
                    <p class="text-sm font-medium text-green-700">Bukti Pembayaran Terkirim</p>
                    <p class="text-xs text-green-500 mt-0.5">Pesanan kamu sedang diproses. Kamu akan mendapat notifikasi saat pesanan dikirim.</p>
                </div>

                <!-- Bukti -->
                @if ($order->bukti_pembayaran)
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="font-bold text-gray-900 mb-3">Bukti Pembayaran</h2>
                    <img src="{{ asset('storage/' . $order->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="w-full rounded-lg border border-gray-100">
                </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="text-center">
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-medium text-sm px-6 py-2.5 rounded-lg transition-colors">
                Kembali ke Toko
            </a>
            @if ($order->status === 'selesai')
            <a href="{{ route('user.invoice', $order) }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm px-6 py-2.5 rounded-lg transition-colors ml-2">
                Lihat Invoice
            </a>
            @else
            <p class="text-xs text-gray-400 mt-3">Invoice tersedia setelah pesanan selesai.</p>
            @endif
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
                    <p class="text-gray-500 text-sm leading-relaxed">Toko buku online terpercaya dengan koleksi terlengkap.</p>
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
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2.5 text-sm text-gray-500">
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

</body>
</html>
