<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challan_id')->nullable()->index();
            $table->foreignId('product_id')->nullable()->index();
            $table->integer('qty')->default(0);
            $table->integer('bill_qty')->default(0);
            $table->integer('unbill_qty')->default(0);
            $table->integer('foc_qty')->default(0);
            $table->foreignId('warranty_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challan_items');
    }
};
