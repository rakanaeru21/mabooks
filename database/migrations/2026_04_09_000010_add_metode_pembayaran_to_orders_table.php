<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('metode_pembayaran', ['qris', 'bayar_di_toko'])->default('qris')->after('status');
            $table->string('kode_pesanan', 10)->nullable()->unique()->after('metode_pembayaran');
            $table->decimal('uang_diterima', 12, 2)->nullable()->after('kode_pesanan');
            $table->decimal('kembalian', 12, 2)->nullable()->after('uang_diterima');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'kode_pesanan', 'uang_diterima', 'kembalian']);
        });
    }
};
