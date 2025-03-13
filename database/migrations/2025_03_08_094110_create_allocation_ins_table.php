<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('allocation_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->foreignId('source_id')->constrained('sources')->onDelete('cascade'); // Relasi ke tabel categories
            $table->decimal('amount', 10, 0); // Jumlah transaksi
            $table->string('date', 7); // Kolom untuk menyimpan bulan dan tahun (format YYYY-MM)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allocation_ins');
    }
};