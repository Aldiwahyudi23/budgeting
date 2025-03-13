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
        Schema::create('account_banks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->string('name'); // Nama kategori
            $table->longText('description')->nullable(); //Keterangan 
            $table->boolean('is_active')->default(true); // Kategori aktif atau tidak
            $table->decimal('amount', 10, 0)->nullable(); // Jumlah pengeluaran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_banks');
    }
};