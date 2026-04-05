<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerServiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $messages = Message::where('user_id', $user->id)->latest()->paginate(10);
        return view('user.customer-service', compact('user', 'messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe' => 'required|in:ulasan,keluhan,masukan,pertanyaan',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string|max:2000',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'tipe' => $validated['tipe'],
            'subjek' => $validated['subjek'],
            'pesan' => $validated['pesan'],
        ]);

        return redirect()->route('user.customer-service')->with('success', 'Pesan berhasil dikirim! Tim kami akan segera merespons.');
    }
}
