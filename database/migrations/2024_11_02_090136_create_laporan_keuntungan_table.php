<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_keuntungan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->decimal('total_penjualan', 15, 2)->default(0);
            $table->decimal('total_modal', 15, 2)->default(0);
            $table->decimal('total_keuntungan', 15, 2)->default(0);
            $table->integer('total_item')->default(0);
            $table->integer('total_produk')->default(0);
            $table->integer('total_transaksi')->default(0);
            $table->enum('periode_laporan', ['daily', 'weekly', 'monthly', 'yearly']);
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('tanggal');
            $table->index('periode_laporan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_keuntungan');
    }
};