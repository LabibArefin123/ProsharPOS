<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('system_problems', function (Blueprint $table) {
            $table->id();
            $table->string('problem_uid')->unique();
            $table->string('problem_title', 150);
            $table->text('problem_description');
            $table->string('status')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_problems');
    }
};
