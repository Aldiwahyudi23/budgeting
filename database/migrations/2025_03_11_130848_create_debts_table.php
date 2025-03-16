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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('amount', 10, 0);
            $table->decimal('paid_amount', 10, 0)->default(0);
            $table->enum('status', ['active', 'paid', 'overdue'])->default('active');
            $table->text('note')->nullable();
            $table->foreignId('sub_category_id')->constrained('sub_categories')->onDelete('cascade');
            $table->enum('type', ['personal', 'installment', 'business'])->default('personal');
            $table->integer('due_date')->nullable();
            $table->integer('tenor_months')->nullable();
            $table->date('last_payment_month')->nullable();
            $table->boolean('reminder')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};