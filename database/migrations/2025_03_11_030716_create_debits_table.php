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
        Schema::create('debits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke users
            $table->enum('type', ['income', 'expense', 'withdraw', 'deposit']); // Jenis transaksi
            $table->string('note')->nullable(); // Catatan transaksi
            $table->decimal('amount', 15, 0); // Jumlah transaksi
            $table->decimal('balance', 15, 0); // Saldo setelah transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debits');
    }
};
