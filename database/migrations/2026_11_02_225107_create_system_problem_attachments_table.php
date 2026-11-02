<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('system_problem_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('system_problem_id')->nullable()->index();
            $table->string('original_name');
            $table->string('file_path');
            $table->string('file_type', 100);
            $table->unsignedBigInteger('file_size');
            // Image dimensions; null for PDFs.
            $table->unsignedInteger('image_width')->nullable();
            $table->unsignedInteger('image_height')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_problem_attachments');
    }
};
