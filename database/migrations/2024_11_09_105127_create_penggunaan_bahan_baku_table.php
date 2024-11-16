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
        Schema::create('penggunaan_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_baku_id')
                ->constrained('bahan_baku')
                ->onDelete('cascade');
            $table->integer('jumlah_digunakan');
            $table->date('tanggal_penggunaan');
            $table->index('tanggal_penggunaan');
            $table->foreignId('produk_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunaan_bahan_baku');
    }
};
