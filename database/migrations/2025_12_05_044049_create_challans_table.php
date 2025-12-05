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
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->date('challan_date')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('challan_total')->default(0);
            $table->integer('challan_bill')->default(0);
            $table->integer('challan_unbill')->default(0);
            $table->integer('challan_foc')->default(0);
            $table->string('pdf_path')->nullable();
            $table->string('challan_ref')->nullable();
            $table->string('out_ref')->nullable();
            $table->unsignedBigInteger('warranty_id')->nullable();
            $table->string('warranty_period')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('status')->nullable(); // delivered, pending, returned
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
        Schema::dropIfExists('challans');
    }
};
