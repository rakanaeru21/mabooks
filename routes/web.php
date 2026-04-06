<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\CustomerServiceController;
use App\Http\Controllers\User\OrderHistoryController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $query = Book::query();

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('penulis', 'like', "%{$search}%")
              ->orWhere('penerbit', 'like', "%{$search}%");
        });
    }

    $books = $query->latest()->take(8)->get();
    return view('welcome', compact('books'));
});

Route::get('/toko', function (Request $request) {
    $query = Book::query();

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('penulis', 'like', "%{$search}%")
              ->orWhere('penerbit', 'like', "%{$search}%");
        });
    }

    $books = $query->latest()->paginate(12);
    return view('toko', compact('books'));
})->name('toko');

// User auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// User dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('user.checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('user.checkout.store');
    Route::get('/payment/{order}', [CheckoutController::class, 'payment'])->name('user.payment');
    Route::post('/payment/{order}', [CheckoutController::class, 'uploadBukti'])->name('user.payment.upload');
    Route::get('/payment/{order}/success', [CheckoutController::class, 'paymentSuccess'])->name('user.payment.success');
    Route::get('/customer-service', [CustomerServiceController::class, 'index'])->name('user.customer-service');
    Route::post('/customer-service', [CustomerServiceController::class, 'store'])->name('user.customer-service.store');
    Route::get('/pesanan', [OrderHistoryController::class, 'index'])->name('user.orders');
});

// Admin auth routes (halaman login admin terpisah)
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin dashboard (dilindungi middleware admin)
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/books', BookController::class)->names('admin.books');
    Route::resource('/categories', CategoryController::class)->names('admin.categories');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/messages', [MessageController::class, 'index'])->name('admin.messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('admin.messages.show');
});
