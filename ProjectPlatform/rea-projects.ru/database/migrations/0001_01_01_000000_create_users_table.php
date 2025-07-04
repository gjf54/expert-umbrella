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
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('login')->unique();
            $table->string('avatar')->default('default.png');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->longText('description')->nullable();
            $table->rememberToken();
            $table->foreignId('registration_token_id')->references('id')->on('registration_tokens')->onUpdate('cascade');
            $table->integer('data_limit')->default(200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
