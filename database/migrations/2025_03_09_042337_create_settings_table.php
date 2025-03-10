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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->boolean('btn_edit')->default(false)->nullable(); // Switch untuk tombol edit
            $table->boolean('btn_delete')->default(false)->nullable(); // Switch untuk tombol hapus
            $table->boolean('expense_saving')->default(false)->nullable(); // Switch untuk Expenses to Savings
            $table->boolean('saving_expense')->default(false)->nullable(); // Switch untuk Savings to Expenses
            $table->boolean('income_saving')->default(false)->nullable(); // Switch untuk Income to Savings
            $table->foreignId('account_id')->nullable()->constrained('account_banks')->onDelete('cascade'); // Relasi ke tabel account_banks
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
