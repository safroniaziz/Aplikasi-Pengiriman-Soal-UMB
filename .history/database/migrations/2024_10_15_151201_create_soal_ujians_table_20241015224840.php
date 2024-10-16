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
            $table->string('nama_file');
            $table->string('path_file');
            $table->string('status');
            $table->text('komentar_kaprodi');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ujian_id')->references('id')->on('ujians');
            $table->foreign('dosen_id')->references('id')->on('ujians');

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
