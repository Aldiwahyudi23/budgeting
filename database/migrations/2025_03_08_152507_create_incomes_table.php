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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->date('date'); // Tanggal pengeluaran
            $table->decimal('amount', 10, 0); // Jumlah pengeluaran
            $table->foreignId('source_id')->constrained('sources')->onDelete('cascade'); // Relasi ke tabel categories
            $table->foreignId('sub_source_id')->nullable()->constrained('sub_sources')->onDelete('cascade'); // Relasi ke tabel sub_categories (opsional)
            $table->string('payment'); // Metode pembayaran
            $table->foreignId('account_id')->nullable()->constrained('account_banks')->onDelete('cascade'); // Relasi ke tabel account_banks
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};