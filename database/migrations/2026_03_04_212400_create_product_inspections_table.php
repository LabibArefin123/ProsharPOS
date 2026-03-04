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
        Schema::create('product_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->index(); // who inspected
            $table->string('inspection_type'); // purchase, routine, return
            $table->string('status'); // passed, failed, partial
            $table->integer('checked_quantity')->nullable();
            $table->integer('defective_quantity')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inspections');
    }
};
