<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pesanan #{{ $order->id }} - {{ config('app.name', 'MaBooks') }}</title>

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
    <style>html { overflow-x: hidden; }</style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0 hidden lg:flex flex-col">
            <div class="px-6 py-5 border-b border-gray-800">
                <a href="/admin/dashboard" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book-open text-white text-sm"></i>
                    </div>
                    <span class="text-lg font-extrabold">Ma<span class="text-orange-500">Books</span></span>
                </a>
                <p class="text-[11px] text-gray-500 mt-1 ml-11">Admin Panel</p>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-chart-pie w-5 text-center"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-users w-5 text-center"></i> Pengguna
                </a>
                <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-book w-5 text-center"></i> Buku
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-orange-500/10 text-orange-500 font-semibold text-sm">
                    <i class="fas fa-shopping-cart w-5 text-center"></i> Pesanan
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-tags w-5 text-center"></i> Kategori
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-file-lines w-5 text-center"></i> Laporan
                </a>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-comments w-5 text-center"></i> Pesan Masuk
                </a>
            </nav>

            <div class="px-4 py-4 border-t border-gray-800">
                <div class="flex items-center gap-3 px-3">
                    <div class="w-9 h-9 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->nama }}</p>
                        <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-red-400 hover:bg-red-500/10 transition-colors text-sm font-medium">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b border-gray-200 px-6 lg:px-8 py-4 flex items-center justify-between">
                <button id="mobile-sidebar-btn" class="lg:hidden text-gray-600 text-xl">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-lg font-bold text-gray-900">Detail Pesanan #{{ $order->id }}</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500 hidden sm:block">Halo, <strong class="text-gray-900">{{ Auth::user()->nama }}</strong></span>
                    <div class="w-9 h-9 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8">
                <!-- Back -->
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-orange-500 transition-colors">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
                    </a>
                    <a href="{{ route('admin.orders.invoice', $order) }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-file-invoice"></i> Lihat Invoice
                    </a>
                </div>

                @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Order Items -->
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
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
                                <div class="flex gap-4 px-6 py-4">
                                    <div class="w-14 h-18 shrink-0 rounded-xl overflow-hidden bg-orange-50 flex items-center justify-center">
                                        @if ($item->book && $item->book->cover)
                                        <img src="{{ asset('storage/' . $item->book->cover) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                        <i class="fas fa-book text-orange-200 text-xl"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-bold text-gray-900">{{ $item->book->judul ?? 'Buku dihapus' }}</h3>
                                        @if ($item->book)
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $item->book->penulis }}</p>
                                        @endif
                                        <div class="flex items-center justify-between mt-2">
                                            <div class="flex items-center gap-3">
                                                <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full font-medium">{{ $item->jumlah }}x</span>
                                                <span class="text-xs text-gray-400">@ Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                            </div>
                                            <p class="text-sm font-extrabold text-orange-500">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
                                <span class="font-bold text-gray-900">Total</span>
                                <span class="text-xl font-extrabold text-orange-500">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Bukti Pembayaran -->
                        @if ($order->metode_pembayaran === 'bayar_di_toko')
                        <!-- Pembayaran di Toko -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-store text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-900">Pembayaran di Toko</h2>
                                    <p class="text-xs text-gray-400">Customer membayar langsung di kasir</p>
                                </div>
                            </div>

                            <!-- Kode Pesanan -->
                            <div class="text-center mb-5 bg-gray-50 rounded-xl p-5">
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">Kode Pesanan</p>
                                <div class="inline-block bg-gray-900 text-white text-2xl font-mono font-extrabold tracking-[0.2em] px-6 py-3 rounded-xl">
                                    {{ $order->kode_pesanan }}
                                </div>
                            </div>

                            @if ($order->uang_diterima)
                            <!-- Sudah dibayar -->
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4 space-y-2">
                                <div class="flex items-center gap-2 text-green-700 font-semibold text-sm mb-2">
                                    <i class="fas fa-check-circle"></i> Pembayaran Diterima
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Total Belanja</span>
                                    <span class="font-bold text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Uang Diterima</span>
                                    <span class="font-bold text-gray-900">Rp {{ number_format($order->uang_diterima, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm border-t border-green-200 pt-2">
                                    <span class="text-gray-600">Kembalian</span>
                                    <span class="font-bold text-orange-500">Rp {{ number_format($order->kembalian, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @else
                            <!-- Form Kasir -->
                            <form method="POST" action="{{ route('admin.orders.processPayment', $order) }}" id="kasir-form">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Total yang Harus Dibayar</label>
                                    <div class="px-4 py-3 bg-orange-50 border border-orange-200 rounded-xl text-lg font-extrabold text-orange-500">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="uang_diterima" class="block text-sm font-semibold text-gray-700 mb-2">Uang yang Diberikan Customer</label>
                                    <input type="number" name="uang_diterima" id="uang_diterima" min="{{ $order->total_harga }}" step="1" required
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500"
                                        placeholder="Masukkan nominal uang..."
                                        oninput="hitungKembalian()">
                                    @error('uang_diterima')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kembalian</label>
                                    <div id="kembalian-display" class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-lg font-extrabold text-gray-400">
                                        Rp 0
                                    </div>
                                </div>
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 rounded-xl transition-colors text-sm">
                                    <i class="fas fa-cash-register mr-1"></i> Proses Pembayaran
                                </button>
                            </form>
                            <script>
                                function hitungKembalian() {
                                    const total = {{ $order->total_harga }};
                                    const uang = parseFloat(document.getElementById('uang_diterima').value) || 0;
                                    const kembalian = uang - total;
                                    const display = document.getElementById('kembalian-display');
                                    if (kembalian >= 0) {
                                        display.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
                                        display.className = 'px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-lg font-extrabold text-green-600';
                                    } else {
                                        display.textContent = 'Uang kurang: Rp ' + Math.abs(kembalian).toLocaleString('id-ID');
                                        display.className = 'px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-lg font-extrabold text-red-500';
                                    }
                                }
                            </script>
                            @endif
                        </div>
                        @else
                        <div class="bg-white rounded-2xl border border-gray-100 p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-9 h-9 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-image text-purple-500 text-sm"></i>
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-900">Bukti Pembayaran</h2>
                                    <p class="text-xs text-gray-400">Verifikasi bukti pembayaran dari customer</p>
                                </div>
                            </div>

                            @if ($order->bukti_pembayaran)
                            <div class="border-2 border-gray-100 rounded-2xl overflow-hidden">
                                <img src="{{ asset('storage/' . $order->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="w-full max-h-[500px] object-contain bg-gray-50">
                            </div>
                            <p class="text-xs text-gray-400 mt-3"><i class="fas fa-info-circle mr-1"></i>Periksa bukti pembayaran di atas. Jika sudah sesuai, ubah status pesanan menjadi "Diproses".</p>
                            @else
                            <div class="text-center py-12 bg-gray-50 rounded-2xl">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-image text-2xl text-gray-300"></i>
                                </div>
                                <p class="text-sm text-gray-400 font-medium">Belum ada bukti pembayaran</p>
                                <p class="text-xs text-gray-400 mt-1">Customer belum mengupload bukti pembayaran.</p>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Info Pemesan -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-user text-blue-500 text-sm"></i>
                                </div>
                                <h2 class="font-bold text-gray-900">Info Pemesan</h2>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Nama</p>
                                    <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $order->user->nama ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Email</p>
                                    <p class="text-sm text-gray-700 mt-0.5">{{ $order->user->email ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Telepon</p>
                                    <p class="text-sm text-gray-700 mt-0.5">{{ $order->user->nomor_telepon ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-green-500 text-sm"></i>
                                </div>
                                <h2 class="font-bold text-gray-900">Alamat Pengiriman</h2>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $order->alamat }}</p>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 bg-indigo-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-credit-card text-indigo-500 text-sm"></i>
                                </div>
                                <h2 class="font-bold text-gray-900">Metode Pembayaran</h2>
                            </div>
                            @if ($order->metode_pembayaran === 'bayar_di_toko')
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-green-600 bg-green-50 px-3 py-1.5 rounded-lg">
                                    <i class="fas fa-store text-xs"></i> Bayar di Toko
                                </span>
                            </div>
                            @if ($order->kode_pesanan)
                            <div class="mt-3 bg-gray-50 rounded-xl p-3 text-center">
                                <p class="text-xs text-gray-400 mb-1">Kode Pesanan</p>
                                <span class="text-lg font-mono font-extrabold text-gray-900 tracking-wider">{{ $order->kode_pesanan }}</span>
                            </div>
                            @endif
                            @else
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-purple-600 bg-purple-50 px-3 py-1.5 rounded-lg">
                                    <i class="fas fa-qrcode text-xs"></i> QRIS
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Status & Update -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-9 h-9 bg-yellow-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-cog text-yellow-600 text-sm"></i>
                                </div>
                                <h2 class="font-bold text-gray-900">Status Pesanan</h2>
                            </div>

                            @php
                                $statusColors = [
                                    'pending' => 'text-yellow-600 bg-yellow-50 border-yellow-200',
                                    'diproses' => 'text-blue-600 bg-blue-50 border-blue-200',
                                    'dikirim' => 'text-purple-600 bg-purple-50 border-purple-200',
                                    'selesai' => 'text-green-600 bg-green-50 border-green-200',
                                    'dibatalkan' => 'text-red-500 bg-red-50 border-red-200',
                                ];
                                $color = $statusColors[$order->status] ?? 'text-gray-500 bg-gray-50 border-gray-200';
                            @endphp

                            <div class="mb-5 px-4 py-3 rounded-xl border {{ $color }} flex items-center gap-2">
                                @if ($order->status === 'pending')
                                    <i class="fas fa-clock"></i>
                                @elseif ($order->status === 'diproses')
                                    <i class="fas fa-spinner"></i>
                                @elseif ($order->status === 'dikirim')
                                    <i class="fas fa-truck"></i>
                                @elseif ($order->status === 'selesai')
                                    <i class="fas fa-check-circle"></i>
                                @elseif ($order->status === 'dibatalkan')
                                    <i class="fas fa-times-circle"></i>
                                @endif
                                <span class="text-sm font-bold capitalize">{{ $order->status }}</span>
                            </div>

                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                                @csrf
                                @method('PATCH')
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Ubah Status</label>
                                <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 bg-white mb-3">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    {{-- <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option> --}}
                                </select>
                                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 rounded-xl transition-colors text-sm">
                                    <i class="fas fa-save mr-1"></i> Perbarui Status
                                </button>
                            </form>
                        </div>

                        <!-- Waktu -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-calendar text-gray-500 text-sm"></i>
                                </div>
                                <h2 class="font-bold text-gray-900">Waktu</h2>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Dibuat</span>
                                    <span class="font-semibold text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Terakhir Update</span>
                                    <span class="font-semibold text-gray-900">{{ $order->updated_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-sidebar-overlay" class="hidden fixed inset-0 z-50 lg:hidden">
        <div class="absolute inset-0 bg-black/50" id="mobile-sidebar-backdrop"></div>
        <aside class="absolute left-0 top-0 bottom-0 w-64 bg-gray-900 text-white flex flex-col">
            <div class="px-6 py-5 border-b border-gray-800 flex items-center justify-between">
                <a href="/admin/dashboard" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book-open text-white text-sm"></i>
                    </div>
                    <span class="text-lg font-extrabold">Ma<span class="text-orange-500">Books</span></span>
                </a>
                <button id="close-sidebar-btn" class="text-gray-400 hover:text-white"><i class="fas fa-xmark text-lg"></i></button>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-chart-pie w-5 text-center"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-users w-5 text-center"></i> Pengguna
                </a>
                <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-book w-5 text-center"></i> Buku
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-orange-500/10 text-orange-500 font-semibold text-sm">
                    <i class="fas fa-shopping-cart w-5 text-center"></i> Pesanan
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-tags w-5 text-center"></i> Kategori
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-file-lines w-5 text-center"></i> Laporan
                </a>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-comments w-5 text-center"></i> Pesan Masuk
                </a>
            </nav>
            <div class="px-4 py-4 border-t border-gray-800">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-red-400 hover:bg-red-500/10 transition-colors text-sm font-medium">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>
    </div>

    <script>
        const sidebarBtn = document.getElementById('mobile-sidebar-btn');
        const sidebarOverlay = document.getElementById('mobile-sidebar-overlay');
        const sidebarBackdrop = document.getElementById('mobile-sidebar-backdrop');
        const closeSidebar = document.getElementById('close-sidebar-btn');

        function toggleSidebar() { sidebarOverlay.classList.toggle('hidden'); }
        sidebarBtn.addEventListener('click', toggleSidebar);
        sidebarBackdrop.addEventListener('click', toggleSidebar);
        closeSidebar.addEventListener('click', toggleSidebar);
    </script>

</body>
</html>
