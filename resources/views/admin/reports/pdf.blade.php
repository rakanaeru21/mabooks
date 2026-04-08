<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan {{ $rangeLabel }} - {{ config('app.name', 'MaBooks') }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; color: #111827; font-size: 12px; }
        h1 { margin: 0 0 4px; font-size: 20px; }
        .muted { color: #6B7280; }
        .header { margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #E5E7EB; }
        .summary { margin: 12px 0 18px; display: flex; gap: 12px; }
        .summary-item { border: 1px solid #E5E7EB; padding: 10px; border-radius: 8px; width: 32%; }
        .summary-item h3 { margin: 0; font-size: 11px; color: #6B7280; }
        .summary-item p { margin: 6px 0 0; font-weight: bold; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #E5E7EB; padding: 8px; text-align: left; }
        th { background: #F9FAFB; font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; }
        .right { text-align: right; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Penjualan</h1>
        <div class="muted">Periode: {{ $rangeLabel }}</div>
        <div class="muted">Dicetak: {{ now()->format('d M Y, H:i') }}</div>
    </div>

    <div class="summary">
        <div class="summary-item">
            <h3>Total Pesanan</h3>
            <p>{{ $totalOrders }}</p>
        </div>
        <div class="summary-item">
            <h3>Total Item</h3>
            <p>{{ $totalItems }}</p>
        </div>
        <div class="summary-item">
            <h3>Total Pendapatan</h3>
            <p>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%">ID</th>
                <th>Nama</th>
                <th class="center" style="width: 10%">Item</th>
                <th class="right" style="width: 16%">Total</th>
                <th class="center" style="width: 14%">Status</th>
                <th class="center" style="width: 16%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->user->nama ?? '-' }}</td>
                <td class="center">{{ $order->items->sum('jumlah') }}</td>
                <td class="right">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td class="center">{{ ucfirst($order->status) }}</td>
                <td class="center">{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="center muted">Tidak ada data untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
