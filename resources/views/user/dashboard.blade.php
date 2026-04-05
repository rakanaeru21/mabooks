<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - {{ config('app.name', 'MaBooks') }}</title>

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
<body class="bg-gray-50 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book-open text-white text-sm"></i>
                </div>
                <span class="text-xl font-extrabold text-gray-900">Ma<span class="text-orange-500">Books</span></span>
            </a>

            <div class="flex items-center gap-4">
                <a href="/" class="text-sm text-gray-500 hover:text-orange-500 transition-colors hidden sm:inline-flex items-center gap-1">
                    <i class="fas fa-store mr-1"></i> Toko
                </a>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm font-semibold text-gray-900">{{ $user->nama }}</p>
                        <p class="text-[11px] text-gray-400">{{ $user->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-600 transition-colors text-sm font-medium" title="Keluar">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <!-- Welcome -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-8 mb-8 text-white">
            <h1 class="text-2xl md:text-3xl font-extrabold mb-2">Selamat Datang, {{ $user->nama }}! 👋</h1>
            <p class="text-orange-100">Kelola akun dan pesanan kamu dari sini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Profil Card -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user text-orange-500"></i>
                    </div>
                    <h2 class="font-bold text-gray-900">Profil Saya</h2>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Nama</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $user->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Email</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Nomor Telepon</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $user->nomor_telepon }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Bergabung Sejak</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Pesanan Card -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-blue-500"></i>
                    </div>
                    <h2 class="font-bold text-gray-900">Pesanan Saya</h2>
                </div>
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <i class="fas fa-box-open text-gray-200 text-5xl mb-4"></i>
                    <p class="text-gray-400 text-sm">Belum ada pesanan.</p>
                    <a href="/" class="mt-4 bg-orange-500 text-white text-sm font-semibold px-6 py-2.5 rounded-full hover:bg-orange-600 transition-colors">
                        <i class="fas fa-shopping-cart mr-1"></i> Mulai Belanja
                    </a>
                </div>
            </div>

            <!-- Menu Cepat -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-bolt text-green-500"></i>
                    </div>
                    <h2 class="font-bold text-gray-900">Menu Cepat</h2>
                </div>
                <div class="space-y-2">
                    <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors text-sm text-gray-600">
                        <i class="fas fa-store w-5 text-center text-orange-500"></i> Jelajahi Toko
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors text-sm text-gray-600">
                        <i class="fas fa-heart w-5 text-center text-red-500"></i> Wishlist
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors text-sm text-gray-600">
                        <i class="fas fa-map-marker-alt w-5 text-center text-blue-500"></i> Alamat Pengiriman
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors text-sm text-gray-600">
                        <i class="fas fa-cog w-5 text-center text-gray-400"></i> Pengaturan Akun
                    </a>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
