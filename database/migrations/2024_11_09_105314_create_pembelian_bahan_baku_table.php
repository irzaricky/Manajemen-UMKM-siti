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
        Schema::create('pembelian_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_baku_id')->constrained('bahan_baku')->onDelete('cascade');
            $table->string('nomor_invoice');              // Purchase invoice number
            $table->integer('jumlah');
            $table->decimal('harga_per_unit', 10, 2);
            $table->decimal('total_harga', 15, 2);
            $table->date('tanggal_pembelian');
            $table->timestamps();
            $table->softDeletes();
            $table->text('keterangan')->nullable();
            $table->index('tanggal_pembelian');
            $table->index('nomor_invoice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_bahan_baku');
    }
};
