<?php

// database/migrations/2025_06_13_184142_create_invoices_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('branch_id');
            $table->date('invoice_date')->nullable();
            $table->text('items')->nullable(); // Store cart JSON
            $table->enum('discount_type', ['percentage', 'flat'])->default('percentage');
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->decimal('sub_total', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('status')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('dollar_amount')->nullable();
            $table->string('paid_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
