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
        Schema::create('validasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('soal_id');
            $table->unsignedBigInteger('kaprodi_id');
            $table->enum('status',['pending','validated','rejected']);
            $table->text('catatan_kaprodi');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('soal_id')->references('id')->on('soal_ujian');
            $table->foreign('kaprodi_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validasis');
    }
};
