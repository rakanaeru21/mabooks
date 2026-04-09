<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->input('metode'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('kode_pesanan', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('nama', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.book');
        return view('admin.orders.show', compact('order'));
    }

    public function invoice(Order $order)
    {
        $order->load('user', 'items.book');

        return view('invoice', [
            'order' => $order,
            'user' => $order->user,
            'backUrl' => route('admin.orders.show', $order),
            'backLabel' => 'Kembali ke Detail Pesanan',
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
        ]);

        $order->update(['status' => $request->input('status')]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function processPayment(Request $request, Order $order)
    {
        if ($order->metode_pembayaran !== 'bayar_di_toko') {
            return redirect()->route('admin.orders.show', $order)->with('error', 'Pesanan ini bukan metode bayar di toko.');
        }

        if ($order->uang_diterima) {
            return redirect()->route('admin.orders.show', $order)->with('error', 'Pesanan ini sudah dibayar.');
        }

        $request->validate([
            'uang_diterima' => 'required|numeric|min:' . $order->total_harga,
        ]);

        $uangDiterima = $request->input('uang_diterima');
        $kembalian = $uangDiterima - $order->total_harga;

        $order->update([
            'uang_diterima' => $uangDiterima,
            'kembalian' => $kembalian,
            'status' => 'selesai',
        ]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Pembayaran berhasil diproses. Kembalian: Rp ' . number_format($kembalian, 0, ',', '.'));
    }
}
