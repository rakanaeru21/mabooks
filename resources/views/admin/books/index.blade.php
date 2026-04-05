<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Buku - {{ config('app.name', 'MaBooks') }}</title>

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
                <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-orange-500/10 text-orange-500 font-semibold text-sm">
                    <i class="fas fa-book w-5 text-center"></i> Buku
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
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
            <!-- Top bar -->
            <header class="bg-white border-b border-gray-200 px-6 lg:px-8 py-4 flex items-center justify-between">
                <button id="mobile-sidebar-btn" class="lg:hidden text-gray-600 text-xl">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-lg font-bold text-gray-900">Kelola Buku</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500 hidden sm:block">Halo, <strong class="text-gray-900">{{ Auth::user()->nama }}</strong></span>
                    <div class="w-9 h-9 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6 lg:p-8">
                <!-- Success Message -->
                @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif

                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Daftar Buku</h2>
                        <p class="text-sm text-gray-500 mt-1">Total {{ $books->total() }} buku</p>
                    </div>
                    <a href="{{ route('admin.books.create') }}" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition-colors">
                        <i class="fas fa-plus"></i> Tambah Buku
                    </a>
                </div>

                <!-- Books Table -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-3">Buku</th>
                                    <th class="px-6 py-3">Penulis</th>
                                    <th class="px-6 py-3">Kategori</th>
                                    <th class="px-6 py-3">Harga</th>
                                    <th class="px-6 py-3">Stok</th>
                                    <th class="px-6 py-3">Tgl Ditambahkan</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse ($books as $book)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($book->cover)
                                            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}" class="w-10 h-14 object-cover rounded-lg">
                                            @else
                                            <div class="w-10 h-14 bg-orange-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-book text-orange-500 text-sm"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $book->judul }}</p>
                                                @if ($book->isbn)
                                                <p class="text-xs text-gray-400">ISBN: {{ $book->isbn }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $book->penulis }}</td>
                                    <td class="px-6 py-4">
                                        @if ($book->category)
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-orange-600 bg-orange-50 px-2.5 py-1 rounded-full">{{ $book->category->nama }}</span>
                                        @else
                                        <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp {{ number_format($book->harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-semibold {{ $book->stok > 0 ? 'text-green-600' : 'text-red-500' }}">{{ $book->stok }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $book->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.books.edit', $book) }}" class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-100 transition-colors" title="Edit">
                                                <i class="fas fa-pen text-xs"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.books.destroy', $book) }}" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 bg-red-50 text-red-500 rounded-lg flex items-center justify-center hover:bg-red-100 transition-colors" title="Hapus">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-400">
                                        <i class="fas fa-book-open text-3xl text-gray-300 mb-3 block"></i>
                                        Belum ada buku. <a href="{{ route('admin.books.create') }}" class="text-orange-500 font-semibold hover:underline">Tambah buku pertama</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($books->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $books->links() }}
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
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
                    <i class="fas fa-users w-5 text-center"></i> Pengguna
                </a>
                <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-orange-500/10 text-orange-500 font-semibold text-sm">
                    <i class="fas fa-book w-5 text-center"></i> Buku
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-colors text-sm">
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
