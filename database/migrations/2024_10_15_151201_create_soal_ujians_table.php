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
        Schema::create('soal_ujians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ujian_id');
            $table->unsignedBigInteger('dosen_id');
            $table->string('judul_soal');
            $table->string('path_file');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ujian_id')->references('id')->on('ujians');
            $table->foreign('dosen_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_ujians');
    }
};
