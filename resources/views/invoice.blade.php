<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ $order->id }} - {{ config('app.name', 'MaBooks') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        amber: {
                            50: '#FFFBEB',
                            100: '#FEF3C7',
                            200: '#FDE68A',
                            300: '#FCD34D',
                            400: '#FBBF24',
                            500: '#F59E0B',
                            600: '#D97706',
                            700: '#B45309',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                        display: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        html { scroll-behavior: smooth; }
        body {
            background: radial-gradient(900px 600px at 90% -10%, #FEF3C7 0%, #FFFBEB 45%, #F5F5F4 100%);
        }
        .paper-shadow {
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.12);
        }
        .pattern-dots {
            background-image: radial-gradient(rgba(148, 163, 184, 0.25) 1px, transparent 1px);
            background-size: 16px 16px;
        }
        @media print {
            .no-print { display: none; }
            body { background: #ffffff; }
            .paper-shadow { box-shadow: none; }
        }
    </style>
</head>
<body class="font-sans text-slate-700">

    <header class="no-print">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 pt-8">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <a href="{{ $backUrl ?? url('/') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-amber-600 transition-colors">
                    <i class="fas fa-arrow-left"></i> {{ $backLabel ?? 'Kembali' }}
                </a>
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-sm px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-print"></i> Cetak Invoice
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-6 lg:px-8 pb-16 pt-6">
        <section class="bg-white rounded-3xl overflow-hidden border border-slate-100 paper-shadow">
            <div class="pattern-dots">
                <div class="px-8 sm:px-10 py-8 border-b border-slate-100">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500 flex items-center justify-center text-white">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-amber-500 font-semibold">MaBooks</p>
                                <h1 class="text-2xl sm:text-3xl font-display text-slate-900">Invoice</h1>
                            </div>
                        </div>
                        <div class="bg-amber-50 border border-amber-100 rounded-2xl px-5 py-4">
                            <p class="text-xs uppercase tracking-wider text-amber-700 font-semibold">Invoice</p>
                            <p class="text-lg font-bold text-slate-900">#{{ $order->id }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-8 sm:px-10 py-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Invoice To</p>
                    <div class="text-slate-800 font-semibold text-base">{{ $order->user->nama ?? $user->nama ?? '-' }}</div>
                    <div class="text-sm text-slate-500">
                        <p>{{ $order->user->email ?? $user->email ?? '-' }}</p>
                        <p>{{ $order->user->nomor_telepon ?? $user->nomor_telepon ?? '-' }}</p>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $order->alamat }}</p>
                </div>
                <div class="space-y-3">
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Status</p>
                    @php
                        $statusLabels = [
                            'pending' => 'Menunggu Pembayaran',
                            'diproses' => 'Diproses',
                            'dikirim' => 'Dikirim',
                            'selesai' => 'Selesai',
                            'dibatalkan' => 'Dibatalkan',
                        ];
                        $statusText = $statusLabels[$order->status] ?? ucfirst($order->status);
                    @endphp
                    <div class="inline-flex items-center gap-2 bg-slate-100 text-slate-600 px-4 py-2 rounded-full text-xs font-semibold">
                        <i class="fas fa-circle text-[8px] text-amber-500"></i>
                        {{ $statusText }}
                    </div>
                    <div class="text-sm text-slate-500">
                        <p>Metode Bayar: Transfer / QRIS</p>
                        <p>No. Pesanan: #{{ $order->id }}</p>
                    </div>
                </div>
            </div>

            <div class="px-8 sm:px-10 pb-8">
                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500">
                            <tr>
                                <th class="text-left px-4 py-3 font-semibold">Item</th>
                                <th class="text-right px-4 py-3 font-semibold">Harga</th>
                                <th class="text-center px-4 py-3 font-semibold">Qty</th>
                                <th class="text-right px-4 py-3 font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($order->items as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-800">{{ $item->book->judul ?? 'Buku dihapus' }}</div>
                                    <div class="text-xs text-slate-400">{{ $item->book->penulis ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-3 text-right text-slate-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center text-slate-600">{{ $item->jumlah }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-slate-800">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="px-8 sm:px-10 pb-10 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Catatan</p>
                    <p class="text-sm text-slate-500 leading-relaxed">Terima kasih sudah berbelanja di MaBooks. Simpan invoice ini sebagai bukti transaksi resmi.</p>
                </div>
                <div class="bg-amber-50 border border-amber-100 rounded-2xl p-5 space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Subtotal</span>
                        <span class="font-semibold text-slate-800">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">Ongkir</span>
                        <span class="font-semibold text-amber-600">Gratis</span>
                    </div>
                    <div class="border-t border-amber-100 pt-3 flex items-center justify-between">
                        <span class="font-semibold text-slate-700">Total</span>
                        <span class="text-xl font-extrabold text-slate-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="px-8 sm:px-10 py-6 border-t border-slate-100 text-xs text-slate-400 flex flex-wrap items-center justify-between gap-2">
                <span>cs@mabooks.id</span>
                <span>+62 812-3456-7890</span>
                <span>mabooks.id</span>
            </div>
        </section>
    </main>

</body>
</html>
