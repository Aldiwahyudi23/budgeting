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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->string('company_name'); // Nama perusahaan
            $table->string('job_title'); // Jabatan pekerjaan
            $table->text('job_description')->nullable(); // Deskripsi pekerjaan
            $table->decimal('salary', 12, 2)->nullable(); // Gaji (maks 999,999,999.99)
            $table->boolean('bpjs')->default(false); // Apakah ada BPJS?
            $table->decimal('bpjs_company_percentage', 5, 2)->nullable(); // Potongan BPJS perusahaan (%)
            $table->decimal('bpjs_employee_percentage', 5, 2)->nullable(); // Potongan BPJS karyawan (%)
            $table->text('benefits')->nullable(); // Keuntungan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};