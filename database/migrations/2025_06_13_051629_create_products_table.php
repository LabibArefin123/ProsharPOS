<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('sku')->unique();
            $table->foreignId('category_id');
            $table->foreignId('brand_id');
            $table->foreignId('unit_id');
            $table->string('part_number')->nullable();
            $table->string('type_model')->nullable();
            $table->string('origin')->nullable();
            $table->smallInteger('rack_number')->nullable();
            $table->smallInteger('box_number')->nullable();
            $table->string('rack_no')->nullable();
            $table->string('rack_location')->nullable();
            $table->string('box_no')->nullable();
            $table->string('box_location')->nullable();
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('handling_charge', 10, 2)->default(0);
            $table->decimal('maintenance_charge', 10, 2)->default(0);
            $table->decimal('sell_price', 10, 2)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->integer('alert_quantity')->default(0);
            $table->string('using_place')->nullable();
            $table->decimal('profit_amount', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->foreignId('warranty_id');
            $table->string('image')->nullable();
            $table->string('barcode_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
