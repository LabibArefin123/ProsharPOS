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
            $table->string('challan_no');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->date('challan_date')->nullable();
            $table->text('items')->nullable();
            $table->integer('challan_total')->default(0);
            $table->integer('challan_bill')->default(0);
            $table->integer('challan_unbill')->default(0);
            $table->integer('challan_foc')->default(0);
            $table->string('pdf_path')->nullable();
            $table->string('challan_ref')->nullable();
            $table->string('out_ref')->nullable();
            $table->unsignedBigInteger('warranty_id')->nullable();
            $table->string('status')->nullable();
            $table->date('valid_until')->nullable();
            $table->text('note')->nullable();
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
