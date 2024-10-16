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
        Schema::create('ujians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mata_kuliah_id');
            $table->date('tanggal_dilaksanakan');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('ruangan');
            $table->dateTime('batas_waktu_upload_soal');  // Kolom baru
            $table
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('mata_kuliah_id')->references('id')->on('mata_kuliahs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujians');
    }
};
