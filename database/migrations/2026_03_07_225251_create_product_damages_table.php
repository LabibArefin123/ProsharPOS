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
        Schema::create('product_damages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_id')->index();
            $table->foreignId('product_id')->index();
            $table->unsignedInteger('damage_qty')->default(0);
            $table->text('damage_description')->nullable();
            $table->string('damage_image')->nullable();
            $table->string('damage_solution')->nullable();
            $table->string('damage_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_damages');
    }
};
