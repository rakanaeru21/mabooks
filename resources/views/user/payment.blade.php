<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran - {{ config('app.name', 'MaBooks') }}</title>

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
            <ul class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <li><a href="{{ route('user.dashboard') }}" class="hover:text-orange-500 transition-colors">Beranda</a></li>
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

    <!-- ==================== HEADER ==================== -->
    <section class="bg-gradient-to-r from-orange-500 to-orange-600 pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white"><i class="fas fa-qrcode mr-3"></i>Pembayaran</h1>
                    <p class="text-orange-100 mt-2 text-sm md:text-base">Scan QRIS dan upload bukti pembayaran untuk pesanan #{{ $order->id }}</p>
                </div>
                <div class="flex items-center gap-3 text-white text-sm">
                    <a href="{{ route('user.dashboard') }}" class="text-orange-200 hover:text-white transition-colors"><i class="fas fa-home mr-1"></i>Toko</a>
                    <i class="fas fa-chevron-right text-orange-300 text-xs"></i>
                    <span class="text-orange-200">Checkout</span>
                    <i class="fas fa-chevron-right text-orange-300 text-xs"></i>
                    <span class="font-semibold">Pembayaran</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== MAIN ==================== -->
    <main class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left: QRIS + Upload -->
            <div class="lg:col-span-2 space-y-6">
                <!-- QRIS Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-9 h-9 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-qrcode text-purple-500 text-sm"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900">Scan QRIS</h2>
                            <p class="text-xs text-gray-400">Scan kode QR di bawah untuk melakukan pembayaran</p>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <div class="bg-white border-2 border-gray-100 rounded-2xl p-4 inline-block">
                            <img src="{{ asset('images/eren mika.jpg') }}" alt="QRIS" class="w-64 h-64 sm:w-72 sm:h-72 object-contain rounded-xl">
                        </div>
                    </div>
                    <div class="mt-6 bg-orange-50 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-orange-500 mt-0.5"></i>
                            <div class="text-sm text-orange-700">
                                <p class="font-semibold mb-1">Petunjuk Pembayaran:</p>
                                <ol class="list-decimal list-inside space-y-1 text-orange-600">
                                    <li>Buka aplikasi e-wallet atau mobile banking kamu</li>
                                    <li>Pilih menu Scan QR / QRIS</li>
                                    <li>Scan kode QR di atas</li>
                                    <li>Masukkan nominal: <strong class="text-orange-700">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></li>
                                    <li>Selesaikan pembayaran lalu screenshot buktinya</li>
                                    <li>Upload bukti pembayaran di bawah</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Bukti -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-upload text-blue-500 text-sm"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900">Upload Bukti Pembayaran</h2>
                            <p class="text-xs text-gray-400">Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                        </div>
                    </div>

                    @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('user.payment.upload', $order) }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Drop zone -->
                        <label for="bukti_pembayaran" class="block cursor-pointer">
                            <div id="drop-zone" class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:border-orange-400 hover:bg-orange-50/50 transition-colors">
                                <div id="upload-placeholder">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-cloud-upload-alt text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-700">Klik untuk pilih file atau drag & drop</p>
                                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP &bull; Maksimal 2MB</p>
                                </div>
                                <div id="upload-preview" class="hidden">
                                    <img id="preview-img" src="" alt="Preview" class="max-h-48 mx-auto rounded-xl mb-3">
                                    <p id="preview-name" class="text-sm font-semibold text-gray-700"></p>
                                    <p class="text-xs text-orange-500 mt-1"><i class="fas fa-edit mr-1"></i>Klik untuk ganti file</p>
                                </div>
                            </div>
                        </label>
                        <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/jpeg,image/png,image/webp" class="hidden" required>

                        <button type="submit" id="btn-upload" disabled class="w-full mt-5 bg-gray-200 text-gray-400 font-bold py-3.5 rounded-2xl text-sm cursor-not-allowed transition-all">
                            <i class="fas fa-paper-plane mr-2"></i>Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-receipt text-green-500 text-sm"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900">Detail Pesanan</h2>
                            <p class="text-xs text-gray-400">Pesanan #{{ $order->id }}</p>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="space-y-3 mb-5">
                        @foreach ($order->items as $item)
                        <div class="flex gap-3">
                            <div class="w-12 h-16 shrink-0 rounded-lg overflow-hidden bg-orange-50 flex items-center justify-center">
                                @if ($item->book && $item->book->cover)
                                <img src="{{ asset('storage/' . $item->book->cover) }}" alt="" class="w-full h-full object-cover">
                                @else
                                <i class="fas fa-book text-orange-200"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 line-clamp-1">{{ $item->book->judul ?? 'Buku dihapus' }}</p>
                                <p class="text-xs text-gray-400">{{ $item->jumlah }}x @ Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                <p class="text-sm font-bold text-orange-500">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Ongkos Kirim</span>
                            <span class="font-semibold text-green-600">Gratis</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 flex items-center justify-between">
                            <span class="font-bold text-gray-900">Total Bayar</span>
                            <span class="text-xl font-extrabold text-orange-500">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-blue-500 text-sm"></i>
                        </div>
                        <h2 class="font-bold text-gray-900">Alamat Pengiriman</h2>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $order->alamat }}</p>
                </div>

                <!-- Status -->
                <div class="bg-orange-50 rounded-2xl border border-orange-100 p-5 flex items-start gap-3">
                    <div class="w-9 h-9 bg-orange-100 rounded-full flex items-center justify-center shrink-0">
                        <i class="fas fa-clock text-orange-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-orange-700">Menunggu Pembayaran</p>
                        <p class="text-xs text-orange-500 mt-0.5">Segera lakukan pembayaran dan upload buktinya.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-gray-900 border-t border-gray-800 mt-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <div>
                    <a href="/" class="flex items-center gap-2 mb-4">
                        <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book-open text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-extrabold text-white">Ma<span class="text-orange-500">Books</span></span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed">Toko buku online terpercaya dengan koleksi terlengkap.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="/" class="text-gray-500 hover:text-orange-500 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('user.dashboard') }}" class="text-gray-500 hover:text-orange-500 transition-colors">Katalog Buku</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Bantuan</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Cara Pemesanan</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-orange-500 transition-colors">Metode Pembayaran</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3"><i class="fas fa-phone text-orange-500"></i><span class="text-gray-500">+62 812-3456-7890</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-envelope text-orange-500"></i><span class="text-gray-500">cs@mabooks.id</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8">
                <p class="text-gray-600 text-sm text-center">&copy; {{ date('Y') }} <span class="text-orange-500 font-semibold">MaBooks</span>. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        const fileInput = document.getElementById('bukti_pembayaran');
        const dropZone = document.getElementById('drop-zone');
        const placeholder = document.getElementById('upload-placeholder');
        const preview = document.getElementById('upload-preview');
        const previewImg = document.getElementById('preview-img');
        const previewName = document.getElementById('preview-name');
        const btnUpload = document.getElementById('btn-upload');

        fileInput.addEventListener('change', handleFile);

        // Drag & drop
        dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-orange-400', 'bg-orange-50/50'); });
        dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('border-orange-400', 'bg-orange-50/50'); });
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-orange-400', 'bg-orange-50/50');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                handleFile();
            }
        });

        function handleFile() {
            const file = fileInput.files[0];
            if (!file) return;

            // Validate
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
                fileInput.value = '';
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                fileInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                previewName.textContent = file.name;
                placeholder.classList.add('hidden');
                preview.classList.remove('hidden');
                btnUpload.disabled = false;
                btnUpload.className = 'w-full mt-5 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-bold py-3.5 rounded-2xl text-sm transition-all shadow-sm shadow-orange-500/30 cursor-pointer';
            };
            reader.readAsDataURL(file);
        }
    </script>

</body>
</html>
