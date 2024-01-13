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
            $table->string('role')->nullable();
            $table->String('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->String('avatar')->nullable();
            $table->String('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->String('address')->nullable();
            $table->String('coin')->default(0);
            $table->String('school_id')->nullable();
            $table->String('education_level')->nullable();
            $table->string('class_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('salary_id')->nullable();
            $table->String('exp')->nullable();
            $table->String('current_role')->nullable();
            $table->String('description')->nullable();
            $table->string('time_tutor_id')->nullable();
            $table->integer('status')->nullable();
            $table->string('District_ID')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('google_id')->nullable();
            $table->text('Certificate')->nullable();
            $table->string('assign_user')->nullable();
            $table->string('Certificate_public',1000)->nullable();
            $table->integer('status_certificate')->default(0);
            $table->string('code')->nullable();
            $table->dateTime('time_accept')->nullable();
            $table->text('add_certificate')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();
            $table->softDeletes();
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
