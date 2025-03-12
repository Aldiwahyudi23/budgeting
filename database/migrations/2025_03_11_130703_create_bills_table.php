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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key ke tabel users
            $table->date('date'); // Kolom tanggal (hanya tanggal)
            $table->decimal('amount', 10, 0); // Kolom jumlah (decimal dengan 10 digit total dan 2 digit di belakang koma)
            $table->text('note')->nullable(); // Kolom catatan (boleh kosong)
            $table->foreignId('sub_category_id')->constrained('sub_categories')->onDelete('cascade'); // Foreign key ke tabel sub_kategoris
            $table->boolean('reminder')->default(false); // Kolom reminder (boolean, default false)
            $table->boolean('auto')->default(false); // Kolom auto (boolean, default false)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};