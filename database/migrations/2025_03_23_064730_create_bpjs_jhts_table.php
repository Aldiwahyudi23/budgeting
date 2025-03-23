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
        Schema::create('bpjs_jhts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->string('company_name'); // Nama perusahaan
            $table->decimal('company_contribution', 15, 2); // Kontribusi perusahaan (CC)
            $table->decimal('employee_contribution', 15, 2); // Kontribusi karyawan (EC)
            $table->decimal('initial_balance', 15, 2); // Saldo awal
            $table->decimal('final_balance', 15, 2); // Saldo akhir
            $table->date('transaction_date'); // Tanggal transaksi
            $table->string('status')->default('Pending'); // Status transaksi
            $table->string('reference_number')->unique(); // Nomor referensi unik
            $table->text('description')->nullable(); // Keterangan (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpjs_jhts');
    }
};