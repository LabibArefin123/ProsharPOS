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
        Schema::create('storages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->index();
            $table->foreignId('supplier_id')->nullable()->index();
            $table->foreignId('manufacturer_id')->nullable()->index();
            $table->unsignedInteger('rack_number');
            $table->unsignedInteger('box_number');
            $table->string('rack_no');
            $table->string('box_no');
            $table->string('rack_location', 150)->nullable();
            $table->string('box_location', 150)->nullable();
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->unsignedInteger('alert_quantity')->default(0);
            $table->unsignedInteger('minimum_stock_level')->default(0);
            $table->unsignedInteger('maximum_stock_level')->default(0);
            $table->unsignedInteger('reorder_quantity')->default(0);
            $table->string('image_path')->nullable();
            $table->string('barcode_path')->nullable();
            $table->boolean('is_active')->default(true);
            
            /* 🧨 Damage Section */
            $table->boolean('is_damaged')->default(false);
            $table->text('damage_description')->nullable();
            $table->string('damage_image')->nullable();
            $table->unsignedInteger('damage_qty')->default(0);
            $table->string('damage_solution')->nullable();

            /* ⏳ Expiry Section */
            $table->boolean('is_expired')->default(false);
            $table->text('expiry_description')->nullable();
            $table->string('expiry_image')->nullable();
            $table->unsignedInteger('expired_qty')->default(0);
            $table->string('error_solution')->nullable();
            $table->string('damage_note');
            $table->string('expiry_note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storages');
    }
};
