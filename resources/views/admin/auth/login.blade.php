<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - {{ config('app.name', 'MaBooks') }}</title>

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
</head>
<body class="bg-gray-900 font-sans antialiased min-h-screen flex items-center justify-center px-4 py-12">

    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2">
                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book-open text-white"></i>
                </div>
                <span class="text-2xl font-extrabold text-white">Ma<span class="text-orange-500">Books</span></span>
            </a>
        </div>

        <!-- Card -->
        <div class="bg-gray-800 rounded-2xl border border-gray-700 p-8">
            <div class="flex items-center justify-center gap-2 mb-2">
                <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shield-halved text-orange-500 text-sm"></i>
                </div>
                <h1 class="text-2xl font-extrabold text-white">Panel Admin</h1>
            </div>
            <p class="text-gray-400 text-sm text-center mb-8">Masuk dengan akun administrator Anda.</p>

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-sm rounded-xl px-4 py-3 mb-6">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-300 mb-1.5">Email Admin</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"><i class="fas fa-envelope text-sm"></i></span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-700 border border-gray-600 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                            placeholder="admin@mabooks.id">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-300 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"><i class="fas fa-lock text-sm"></i></span>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-700 border border-gray-600 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                            placeholder="Masukkan password">
                    </div>
                </div>

                <div class="flex items-center">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-600 bg-gray-700 text-orange-500 focus:ring-orange-500">
                        <span class="text-sm text-gray-400">Ingat saya</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-orange-500 text-white font-semibold py-3.5 rounded-xl hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/25 text-sm">
                    <i class="fas fa-right-to-bracket mr-2"></i>Masuk sebagai Admin
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-600 mt-6">
            <a href="/" class="hover:text-orange-500 transition-colors"><i class="fas fa-arrow-left mr-1"></i>Kembali ke Beranda</a>
        </p>
    </div>

</body>
</html>
