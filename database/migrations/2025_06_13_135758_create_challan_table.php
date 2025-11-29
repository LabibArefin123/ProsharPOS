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
        Schema::create('challans', function (Blueprint $table) {
            $table->id();
            $table->string('challan_no')->unique();
            $table->date('challan_date')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('branch_id');
            $table->integer('quantity')->default(0);
            $table->string('pdf_path')->nullable();
            $table->string('challan_ref')->nullable();
            $table->string('out_ref')->nullable();
            $table->unsignedBigInteger('warranty_id')->nullable();
            $table->string('warranty_period')->nullable(); // e.g. 1 year, 6 months
            $table->string('serial_no')->nullable();
            $table->string('status'); // pending, delivered, etc.
            $table->date('valid_until')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challan');
    }
};
