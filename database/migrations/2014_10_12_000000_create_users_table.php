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
            $table->string('role');
            $table->string('name');
            $table->string('email')->unique();
            $table->String('avatar')->nullable();
            $table->String('phone');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->String('address');
            $table->integer('school_id')->nullable();
            $table->String('Citizen_card')->nullable();
            $table->String('education_level')->nullable();
            $table->integer('class')->nullable();
            $table->integer('subject')->nullable();
            $table->integer('salary')->nullable();
            $table->String('description')->nullable();
            $table->integer('time_tutor')->nullable();
            $table->string('status')->nullable();
            $table->integer('DistrictID')->nullable();
            $table->String('Certificate')->nullable();
            $table->rememberToken()->nullable();
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
