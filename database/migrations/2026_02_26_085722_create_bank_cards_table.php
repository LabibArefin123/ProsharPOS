<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bank_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_balance_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('payment_date');
            $table->string('card_type'); // Visa, MasterCard, Amex, etc.
            $table->string('card_holder_name');
            $table->string('card_last_four', 4); // last 4 digits only
            $table->decimal('amount', 15, 2);
            $table->decimal('amount_in_dollar', 15, 2)->nullable();
            $table->string('reference_no')->unique();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_cards');
    }
};
