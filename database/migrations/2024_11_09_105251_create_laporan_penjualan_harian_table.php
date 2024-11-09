<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_penjualan_harian', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->decimal('total_penjualan', 15, 2);
            $table->integer('total_item');
            $table->integer('total_transaksi');
            $table->decimal('total_keuntungan', 15, 2);
            $table->string('status')->default('active');
            $table->timestamps();
            $table->index('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_penjualan_harian');
    }
};
