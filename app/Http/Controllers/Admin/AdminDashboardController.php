<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', '=', 'user')->count();
        $totalAdmins = User::where('role', '=', 'admin')->count();
        $totalBooks = Book::count();
        $totalOrders = Order::count();
        $recentUsers = User::where('role', '=', 'user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalAdmins', 'totalBooks', 'totalOrders', 'recentUsers'));
    }
}
