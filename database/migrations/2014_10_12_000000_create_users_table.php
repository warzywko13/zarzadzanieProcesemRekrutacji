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
            $table->string('email')->unique();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('password')->nullable();
            $table->integer('sex')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('post_code')->nullable();
            $table->string('street')->nullable();
            $table->integer('street_number')->nullable();
            $table->integer('flat_number')->nullable();
            $table->integer('position_id')->nullable();
            $table->string('position_name')->nullable();
            $table->timestamp('start_from')->nullable();
            $table->unsignedBigInteger('photo_id')->nullable();
            $table->integer('is_recruiter')->default(0);
            $table->integer('deleted')->default(0);
            $table->timestamp('deleted_at')->nullable();
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
