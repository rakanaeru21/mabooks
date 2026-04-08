<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - {{ config('app.name', 'MaBooks') }}</title>

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

    <!-- Sidebar + Main -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0 hidden lg:flex flex-col">
            <!-- Logo -->
            <div class="px-6 py-5 border-b border-gray-800">
                <a href="/admin/dashboard" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book-open text-white text-sm"></i>
                    </div>
                    <span class="text-lg font-extrabold">Ma<span class="text-orange-500">Books</span></span>
                </a>
                <p class="text-[11px] text-gray-500 mt-1 ml-11">Admin Panel</p>
            </div>

            <!-- Nav -->
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-orange-500/10 text-orange-500 font-semibold text-sm">
                    <i class="fas fa-chart-pie w-5 text-center"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-users w-5 text-center"></i> Pengguna
                </a>
                <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-book w-5 text-center"></i> Buku
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
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

            <!-- User Info -->
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
            <!-- Top bar -->
            <header class="bg-white border-b border-gray-200 px-6 lg:px-8 py-4 flex items-center justify-between">
                <!-- Mobile menu -->
                <button id="mobile-sidebar-btn" class="lg:hidden text-gray-600 text-xl">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-lg font-bold text-gray-900">Dashboard</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500 hidden sm:block">Halo, <strong class="text-gray-900">{{ Auth::user()->nama }}</strong></span>
                    <div class="w-9 h-9 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6 lg:p-8">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                            <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-1 rounded-full"><i class="fas fa-arrow-up mr-1"></i>Aktif</span>
                        </div>
                        <p class="text-2xl font-extrabold text-gray-900">{{ $totalUsers }}</p>
                        <p class="text-sm text-gray-500 mt-1">Total Pengguna</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-shield text-orange-600"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-extrabold text-gray-900">{{ $totalAdmins }}</p>
                        <p class="text-sm text-gray-500 mt-1">Total Admin</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-book text-purple-600"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-extrabold text-gray-900">{{ $totalBooks }}</p>
                        <p class="text-sm text-gray-500 mt-1">Total Buku</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-green-600"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-extrabold text-gray-900">{{ $totalOrders }}</p>
                        <p class="text-sm text-gray-500 mt-1">Total Pesanan</p>
                    </div>
                </div>

                <!-- Recent Users Table -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="font-bold text-gray-900">Pengguna Terbaru</h2>
                        <a href="{{ route('admin.users.index') }}" class="text-orange-500 text-sm font-semibold hover:text-orange-600 transition-colors">Lihat Semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-3">Nama</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">No. Telepon</th>
                                    <th class="px-6 py-3">Tgl Daftar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse ($recentUsers as $u)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($u->nama, 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-semibold text-gray-900">{{ $u->nama }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $u->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $u->nomor_telepon }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $u->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-400">Belum ada pengguna terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-orange-500/10 text-orange-500 font-semibold text-sm">
                    <i class="fas fa-chart-pie w-5 text-center"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-users w-5 text-center"></i> Pengguna
                </a>
                <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-book w-5 text-center"></i> Buku
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
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
