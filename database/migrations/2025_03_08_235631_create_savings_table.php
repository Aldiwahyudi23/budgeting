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
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->date('date'); // Tanggal transaksi
            $table->decimal('amount', 10, 0); // Jumlah transaksi (bisa positif atau negatif)
            $table->text('note')->nullable(); // Catatan transaksi
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Relasi ke tabel categories
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->onDelete('cascade'); // Relasi ke tabel sub_categories
            $table->decimal('balance', 10, 0)->default(0); // Saldo setelah transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings');
    }
};