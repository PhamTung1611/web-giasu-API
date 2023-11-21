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
        Schema::create('connect', function (Blueprint $table) {
            $table->id();
            $table->string('idJob');
            $table->string('idUser');
            $table->string('idTeacher');
            $table->string('noteUser')->nullable();
            $table->string('noteTeacher')->nullable();
            $table->string('confirmUser')->default(0);
            $table->string('confirmTeacher')->default(0);
            $table->string('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connect');
    }
};
