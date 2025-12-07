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
        Schema::create('petty_cashes', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->nullable()->index();
            $table->enum('type', ['receive', 'expense']);
            $table->string('reference_type')->nullable(); // e.g. cash_in, cash_out, transfer
            $table->string('item_name')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('amount_in_dollar', 15, 2)->nullable();
            $table->decimal('exchange_rate', 18, 6)->nullable();
            $table->string('currency', 10)->default('BDT');
            $table->string('payment_method')->nullable();
            $table->foreignId('bank_balance_id')->nullable()->index();
            $table->foreignId('supplier_id')->nullable()->index();
            $table->foreignId('customer_id')->nullable()->index();
            $table->string('category')->nullable();
            $table->text('note')->nullable();
            $table->string('attachment')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('status'); //['pending', 'approved', 'rejected']
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petty_cashes');
    }
};
