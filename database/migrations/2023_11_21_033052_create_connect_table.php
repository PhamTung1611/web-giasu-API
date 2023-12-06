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
            $table->string('id_job');
            $table->string('id_user');
            $table->string('id_teacher');
            $table->string('note_user')->nullable();
            $table->string('note_teacher')->nullable();
            $table->integer('confirm_user')->default(0);
            $table->integer('confirm_teacher')->default(0);
            $table->integer('status')->default(0);
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
