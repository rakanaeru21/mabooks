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

    <!-- ==================== NAVBAR COY ==================== -->
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

    <!-- ==================== KONTEN UTAMA NIH BOS ==================== -->
    <main class="max-w-7xl mx-auto px-6 lg:px-8 pt-28 pb-16">

        <!-- Kartu Sukses — Mantap Jiwa 🔥 -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8 mb-8 flex flex-col md:flex-row items-center gap-6">
            <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center shrink-0 animate-check">
                <i class="fas fa-check-circle text-3xl text-green-500"></i>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-1">Pembayaran Terkirim!</h1>
                <p class="text-gray-500 text-sm">Bukti pembayaran kamu telah berhasil dikirim. Pesanan akan segera diproses oleh admin.</p>
            </div>
            <div class="flex flex-col items-center gap-2 shrink-0">
                <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 font-bold text-sm px-5 py-2.5 rounded-xl border border-orange-100">
                    <i class="fas fa-receipt"></i> Pesanan #{{ $order->id }}
                </div>
                <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full capitalize
                    @if($order->status === 'pending') bg-yellow-50 text-yellow-600 border border-yellow-200
                    @elseif($order->status === 'diproses') bg-blue-50 text-blue-600 border border-blue-200
                    @elseif($order->status === 'dikirim') bg-purple-50 text-purple-600 border border-purple-200
                    @elseif($order->status === 'selesai') bg-green-50 text-green-600 border border-green-200
                    @elseif($order->status === 'dibatalkan') bg-red-50 text-red-500 border border-red-200
                    @else bg-gray-50 text-gray-500 border border-gray-200
                    @endif">
                    @if($order->status === 'pending')<i class="fas fa-clock"></i>
                    @elseif($order->status === 'diproses')<i class="fas fa-spinner"></i>
                    @elseif($order->status === 'dikirim')<i class="fas fa-truck"></i>
                    @elseif($order->status === 'selesai')<i class="fas fa-check-circle"></i>
                    @elseif($order->status === 'dibatalkan')<i class="fas fa-times-circle"></i>
                    @endif
                    {{ $order->status }}
                </span>
            </div>
        </div>

        @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-2xl text-sm flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-2xl text-sm flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        <!-- Banner Status — Lagi Nunggu Nih -->
        <div class="bg-green-50 rounded-2xl border border-green-100 px-6 py-4 mb-8 flex items-center gap-3">
            <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center shrink-0">
                <i class="fas fa-clock text-green-600 text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-green-700">Menunggu Konfirmasi Admin</p>
                <p class="text-xs text-green-600 mt-0.5">Pesanan kamu sedang diproses. Kamu akan mendapat notifikasi saat pesanan dikirim.</p>
            </div>
        </div>

        <!-- Baris Atas: 3 kartu info sejajar, rapih bener dah -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Alamat Kirim — Mau Dikirim Kemana Nih -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-blue-500 text-sm"></i>
                    </div>
                    <h2 class="font-bold text-gray-900">Alamat Pengiriman</h2>
                </div>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $order->alamat }}</p>
            </div>

            <!-- Detail Orderan — Info Lengkapnya Nih -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar text-purple-500 text-sm"></i>
                    </div>
                    <h2 class="font-bold text-gray-900">Detail Pesanan</h2>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Tanggal Pesan</span>
                        <span class="font-semibold text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Metode</span>
                        <span class="font-semibold text-gray-900">Transfer Bank</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Total Item</span>
                        <span class="font-semibold text-gray-900">{{ $order->items->sum('jumlah') }} buku</span>
                    </div>
                </div>
            </div>

            <!-- Total Bayar — Segini Dong Bossque -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-wallet text-orange-500 text-sm"></i>
                    </div>
                    <h2 class="font-bold text-gray-900">Total Pembayaran</h2>
                </div>
                <p class="text-3xl font-extrabold text-orange-500">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-2">Sudah termasuk seluruh item pesanan</p>
            </div>
        </div>

        <!-- Baris Bawah: Barang + Bukti Bayar Sebelahan -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Barang Yang Dipesan — Cekidot -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-orange-500 text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-900">Item Pesanan</h2>
                        <p class="text-xs text-gray-400">{{ $order->items->sum('jumlah') }} buku dipesan</p>
                    </div>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach ($order->items as $item)
                    <div class="flex gap-4 px-6 py-4 items-center">
                        <div class="w-12 h-16 shrink-0 rounded-xl overflow-hidden bg-orange-50 flex items-center justify-center">
                            @if ($item->book && $item->book->cover)
                            <img src="{{ asset('storage/' . $item->book->cover) }}" alt="" class="w-full h-full object-cover">
                            @else
                            <i class="fas fa-book text-orange-200 text-lg"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 line-clamp-1">{{ $item->book->judul ?? 'Buku dihapus' }}</p>
                            @if ($item->book)
                            <p class="text-xs text-gray-400 mt-0.5">{{ $item->book->penulis }}</p>
                            @endif
                            <div class="flex items-center gap-3 mt-1.5">
                                <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">{{ $item->jumlah }}x</span>
                                <span class="text-xs text-gray-400">@ Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <p class="text-sm font-extrabold text-orange-500 shrink-0">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
                    <span class="font-bold text-gray-900">Total</span>
                    <span class="text-lg font-extrabold text-orange-500">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Bukti Bayar — Udah Transfer Belom? -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-image text-emerald-500 text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-900">Bukti Pembayaran</h2>
                        <p class="text-xs text-gray-400">Bukti transfer yang telah kamu kirim</p>
                    </div>
                </div>
                @if ($order->bukti_pembayaran)
                <div class="p-6 flex justify-center bg-gray-50">
                    <img src="{{ asset('storage/' . $order->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="max-h-[400px] w-auto rounded-xl border border-gray-200 shadow-sm">
                </div>
                @else
                <div class="p-6 flex flex-col items-center justify-center bg-gray-50 min-h-[200px]">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                        <i class="fas fa-image text-2xl text-gray-300"></i>
                    </div>
                    <p class="text-sm text-gray-400 font-medium">Belum ada bukti pembayaran</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Tombol Aksi — Mau Ngapain Lagi Nih -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            @if ($order->status === 'dikirim')
            <form method="POST" action="{{ route('user.orders.confirmReceived', $order) }}" onsubmit="return confirm('Apakah kamu yakin produk sudah diterima?')">
                @csrf
                @method('PATCH')
                <button type="submit" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold text-sm px-6 py-3 rounded-xl transition-colors shadow-sm">
                    <i class="fas fa-box-open"></i> Konfirmasi Diterima
                </button>
            </form>
            @endif
            <a href="{{ route('user.orders') }}" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold text-sm px-6 py-3 rounded-xl transition-colors shadow-sm">
                <i class="fas fa-list-ul text-gray-400"></i> Lihat Pesanan Saya
            </a>
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm px-6 py-3 rounded-xl transition-colors shadow-sm">
                <i class="fas fa-store"></i> Kembali ke Toko
            </a>
            @if ($order->status === 'selesai')
            <a href="{{ route('user.invoice', $order) }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-sm px-6 py-3 rounded-xl transition-colors shadow-sm">
                <i class="fas fa-file-invoice"></i> Lihat Invoice
            </a>
            @endif
        </div>
        @if ($order->status !== 'selesai')
        <p class="text-xs text-gray-400 text-center mt-3"><i class="fas fa-info-circle mr-1"></i>Invoice tersedia setelah pesanan selesai.</p>
        @endif
    </main>

    <!-- ==================== FOOTER — KAKI HALAMAN GAES ==================== -->
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
