<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Link to users
            $table->decimal('balance', 12, 2)->default(0); // Current balance
            $table->decimal('balance_in_dollars', 12, 2)->default(0); // Current balance
            $table->string('currency', 10)->default('BDT'); // Currency
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_balances');
    }
};
