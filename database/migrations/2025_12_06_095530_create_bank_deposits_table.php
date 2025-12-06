<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_balance_id')->index(); 
            $table->foreignId('user_id')->nullable()->index();   
            $table->date('deposit_date');
            $table->decimal('amount', 15, 2);
            $table->decimal('amount_in_dollar', 15, 2);
            $table->string('deposit_method')->comment('cash, cheque, bkash, nagad, transfer');
            $table->string('reference_no')->nullable();
            $table->string('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_deposits');
    }
};
