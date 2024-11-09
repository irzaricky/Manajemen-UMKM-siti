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
        // Create bahan_baku table (singular)
        Schema::create('bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('stok');
            $table->string('satuan');
            $table->decimal('harga_per_unit', 10, 2);
            $table->integer('minimum_stok')->default(0);  // Added for stock warnings
            $table->text('keterangan')->nullable();       // Added for notes
            $table->timestamps();
            $table->softDeletes();                        // Added for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_baku');
    }
};
