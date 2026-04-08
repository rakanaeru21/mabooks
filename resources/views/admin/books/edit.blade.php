<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Buku - {{ config('app.name', 'MaBooks') }}</title>

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
                <h1 class="text-lg font-bold text-gray-900">Edit Buku</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500 hidden sm:block">Halo, <strong class="text-gray-900">{{ Auth::user()->nama }}</strong></span>
                    <div class="w-9 h-9 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8">

                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
                    <a href="/admin/dashboard" class="hover:text-gray-600 transition-colors">Dashboard</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <a href="{{ route('admin.books.index') }}" class="hover:text-gray-600 transition-colors">Kelola Buku</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-700 font-medium">Edit: {{ Str::limit($book->judul, 40) }}</span>
                </div>

                <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                    <!-- Left: Form Fields -->
                    <div class="xl:col-span-2 space-y-6">

                        <!-- Informasi Utama -->
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book text-orange-500 text-sm"></i>
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-900 text-sm">Informasi Utama</h2>
                                    <p class="text-xs text-gray-400">Judul, penulis, dan penerbit</p>
                                </div>
                            </div>
                            <div class="p-6 space-y-4">
                                <div>
                                    <label for="judul" class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Buku <span class="text-red-500">*</span></label>
                                    <input type="text" name="judul" id="judul" value="{{ old('judul', $book->judul) }}" required
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors">
                                    @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="penulis" class="block text-sm font-semibold text-gray-700 mb-1.5">Penulis <span class="text-red-500">*</span></label>
                                        <input type="text" name="penulis" id="penulis" value="{{ old('penulis', $book->penulis) }}" required
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors">
                                        @error('penulis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="penerbit" class="block text-sm font-semibold text-gray-700 mb-1.5">Penerbit</label>
                                        <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit', $book->penerbit) }}"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors">
                                        @error('penerbit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Penerbitan -->
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-info-circle text-blue-500 text-sm"></i>
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-900 text-sm">Detail Penerbitan</h2>
                                    <p class="text-xs text-gray-400">Tahun terbit, ISBN, harga, dan stok</p>
                                </div>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="tahun_terbit" class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun Terbit</label>
                                        <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', $book->tahun_terbit) }}" min="1901" max="{{ date('Y') + 1 }}"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors">
                                        @error('tahun_terbit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="isbn" class="block text-sm font-semibold text-gray-700 mb-1.5">ISBN</label>
                                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors">
                                        @error('isbn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="harga" class="block text-sm font-semibold text-gray-700 mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">Rp</span>
                                            <input type="number" name="harga" id="harga" value="{{ old('harga', $book->harga) }}" min="0" step="100" required
                                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors">
                                        </div>
                                        @error('harga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="stok" class="block text-sm font-semibold text-gray-700 mb-1.5">Stok <span class="text-red-500">*</span></label>
                                        <input type="number" name="stok" id="stok" value="{{ old('stok', $book->stok) }}" min="0" required
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors">
                                        @error('stok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori</label>
                                    <select name="category_id" id="category_id"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors bg-white">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-align-left text-purple-500 text-sm"></i>
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-900 text-sm">Deskripsi</h2>
                                    <p class="text-xs text-gray-400">Sinopsis atau ringkasan buku</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <textarea name="deskripsi" id="deskripsi" rows="5"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors resize-none">{{ old('deskripsi', $book->deskripsi) }}</textarea>
                                @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right: Cover & Actions -->
                    <div class="space-y-6">

                        <!-- Cover Upload -->
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-green-500 text-sm"></i>
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-900 text-sm">Cover Buku</h2>
                                    <p class="text-xs text-gray-400">Foto sampul buku</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <!-- Preview Area -->
                                <div class="mb-4 flex justify-center">
                                    @if ($book->cover)
                                    <img id="cover-preview" src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}" class="w-32 h-44 object-cover rounded-xl border border-gray-200">
                                    @else
                                    <div id="cover-placeholder" class="w-32 h-44 bg-gray-100 rounded-xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400">
                                        <i class="fas fa-image text-2xl mb-2"></i>
                                        <span class="text-xs">Preview</span>
                                    </div>
                                    <img id="cover-preview" src="#" alt="Preview" class="hidden w-32 h-44 object-cover rounded-xl border border-gray-200">
                                    @endif
                                </div>
                                <!-- Upload Button -->
                                <label for="cover" class="cursor-pointer flex items-center justify-center gap-2 w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-500 hover:border-orange-500 hover:text-orange-500 hover:bg-orange-50 transition-colors">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span id="cover-label">{{ $book->cover ? 'Ganti cover' : 'Pilih file gambar' }}</span>
                                </label>
                                <input type="file" name="cover" id="cover" accept="image/jpg,image/jpeg,image/png,image/webp" class="hidden"
                                    onchange="document.getElementById('cover-label').textContent = this.files[0]?.name || 'Pilih file gambar'; if(this.files[0]){ const r = new FileReader(); r.onload = e => { document.getElementById('cover-preview').src = e.target.result; document.getElementById('cover-preview').classList.remove('hidden'); const ph = document.getElementById('cover-placeholder'); if(ph) ph.classList.add('hidden'); }; r.readAsDataURL(this.files[0]); }">
                                <p class="text-xs text-gray-400 mt-2 text-center">JPG, PNG, WebP. Maks 2MB.</p>
                                @error('cover') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-3">
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm px-6 py-3 rounded-xl transition-colors">
                                <i class="fas fa-save"></i> Perbarui Buku
                            </button>
                            <a href="{{ route('admin.books.index') }}" class="w-full flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm px-6 py-3 rounded-xl transition-colors">
                                Batal
                            </a>
                        </div>

                        <!-- Book Info -->
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                            <p class="text-xs font-semibold text-gray-600 mb-3 flex items-center gap-1.5"><i class="fas fa-clock text-gray-400"></i> Info Buku</p>
                            <div class="space-y-2 text-xs text-gray-500">
                                <div class="flex justify-between">
                                    <span>Ditambahkan</span>
                                    <span class="font-medium text-gray-700">{{ $book->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Diperbarui</span>
                                    <span class="font-medium text-gray-700">{{ $book->updated_at->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>ID Buku</span>
                                    <span class="font-medium text-gray-700">#{{ $book->id }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
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
                <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-orange-500/10 text-orange-500 font-semibold text-sm">
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
