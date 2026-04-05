<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.checkout', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alamat' => 'required|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.book_id' => 'required|exists:books,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        $order = DB::transaction(function () use ($validated, $user) {
            $totalHarga = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $book = Book::lockForUpdate()->findOrFail($item['book_id']);

                if ($book->stok < $item['jumlah']) {
                    throw new \Exception("Stok buku \"{$book->judul}\" tidak mencukupi. Sisa stok: {$book->stok}");
                }

                $subtotal = $book->harga * $item['jumlah'];
                $totalHarga += $subtotal;

                $orderItems[] = [
                    'book_id' => $book->id,
                    'jumlah' => $item['jumlah'],
                    'harga' => $book->harga,
                ];

                $book->decrement('stok', $item['jumlah']);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'alamat' => $validated['alamat'],
                'total_harga' => $totalHarga,
                'status' => 'pending',
            ]);

            $order->items()->createMany($orderItems);

            return $order;
        });

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat!',
            'order_id' => $order->id,
        ]);
    }

    public function payment(Order $order)
    {
        $user = Auth::user();

        if ($order->user_id !== $user->id) {
            abort(403);
        }

        if ($order->bukti_pembayaran) {
            return redirect()->route('user.payment.success', $order);
        }

        $order->load('items.book');
        return view('user.payment', compact('user', 'order'));
    }

    public function uploadBukti(Request $request, Order $order)
    {
        $user = Auth::user();

        if ($order->user_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        $order->update([
            'bukti_pembayaran' => $path,
            'status' => 'diproses',
        ]);

        return redirect()->route('user.payment.success', $order);
    }

    public function paymentSuccess(Order $order)
    {
        $user = Auth::user();

        if ($order->user_id !== $user->id) {
            abort(403);
        }

        $order->load('items.book');
        return view('user.payment-success', compact('user', 'order'));
    }
}
