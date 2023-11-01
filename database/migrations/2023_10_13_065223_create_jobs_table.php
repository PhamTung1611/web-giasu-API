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
        // Schema::create('jobs', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('title');
        //     $table->string('name');
        //     $table->string('address');
        //     $table->string('date_time');
        //     $table->string('phone')->unique();
        //     $table->string('email')->unique();
        //     $table->string('subjects_need');
        //     $table->string('education_level');
        //     $table->string('salary');
        //     $table->string('requirements');
        //     $table->softDeletes();
        //     $table->timestamps();
        // });

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('idUser');
            $table->string('idTeacher');
            $table->string('subject');
            $table->string('class');
            $table->tinyInteger('status')->default(0);
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
