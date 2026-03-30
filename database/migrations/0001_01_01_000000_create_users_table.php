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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');

            $table->rememberToken();

            // 📱 Contact
            $table->string('phone')->nullable();
            $table->string('phone_2')->nullable();

            // 🖼 Profile
            $table->string('profile_picture')->nullable();

            // 🔐 Two Factor
            $table->boolean('two_factor_enabled')->default(0);
            $table->string('two_factor_code', 10)->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();

            // ⏱ Session
            $table->float('session_timeout')->default(5);

            // 🛠 Maintenance Mode
            $table->boolean('is_maintenance')->default(0);
            $table->string('maintenance_message')->nullable();

            // 🚫 Ban System
            $table->boolean('is_banned')->default(0);

            $table->boolean('is_notifications')->default(0);
            // 🟢 Online Status
            $table->timestamp('last_seen')->nullable();

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
