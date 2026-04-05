<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Pesanan - {{ config('app.name', 'MaBooks') }}</title>

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
                <h1 class="text-lg font-bold text-gray-900">Kelola Pesanan</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500 hidden sm:block">Halo, <strong class="text-gray-900">{{ Auth::user()->nama }}</strong></span>
                    <div class="w-9 h-9 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8">
                @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif

                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Daftar Pesanan</h2>
                        <p class="text-sm text-gray-500 mt-1">Total {{ $orders->total() }} pesanan</p>
                    </div>
                </div>

                <!-- Search & Filter -->
                <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-6">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID pesanan atau nama/email pengguna..." class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                        </div>
                        <select name="status" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 bg-white">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="dikirim" {{ request('status') === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <button type="submit" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition-colors">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        @if(request('search') || request('status'))
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold text-sm px-5 py-2.5 rounded-xl transition-colors">
                            <i class="fas fa-times"></i> Reset
                        </a>
                        @endif
                    </div>
                </form>

                <!-- Orders Table -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Pemesan</th>
                                    <th class="px-6 py-3">Jumlah Item</th>
                                    <th class="px-6 py-3">Total</th>
                                    <th class="px-6 py-3">Bukti Bayar</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse ($orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-bold text-orange-500">#{{ $order->id }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($order->user->nama ?? '?', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $order->user->nama ?? '-' }}</p>
                                                <p class="text-xs text-gray-400">{{ $order->user->email ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->items->sum('jumlah') }} buku</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        @if ($order->bukti_pembayaran)
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">
                                            <i class="fas fa-check-circle text-[10px]"></i> Sudah
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-red-500 bg-red-50 px-2.5 py-1 rounded-full">
                                            <i class="fas fa-times-circle text-[10px]"></i> Belum
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'text-yellow-600 bg-yellow-50',
                                                'diproses' => 'text-blue-600 bg-blue-50',
                                                'dikirim' => 'text-purple-600 bg-purple-50',
                                                'selesai' => 'text-green-600 bg-green-50',
                                                'dibatalkan' => 'text-red-500 bg-red-50',
                                            ];
                                            $color = $statusColors[$order->status] ?? 'text-gray-500 bg-gray-50';
                                        @endphp
                                        <span class="inline-flex items-center text-xs font-semibold {{ $color }} px-2.5 py-1 rounded-full capitalize">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-100 transition-colors" title="Detail">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center text-sm text-gray-400">
                                        <i class="fas fa-shopping-cart text-3xl text-gray-300 mb-3 block"></i>
                                        Belum ada pesanan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($orders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $orders->links() }}
                    </div>
                    @endif
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
