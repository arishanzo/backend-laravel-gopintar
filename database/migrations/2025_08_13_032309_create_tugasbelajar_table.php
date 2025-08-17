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
        Schema::create('tugasbelajar', function (Blueprint $table) {
            $table->id('idtugasbelajar');
            $table->integer('iduser')->unique();
            $table->integer('idguru')->unique();
            $table->string('namatugas')->nullable();
            $table->text('deskripsitugas')->nullable();
            $table->date('tanggaltugas')->nullable();
            $table->string('filetugas')->nullable();
            $table->enum('statustugas', ['selesai', 'belum selesai'])->default('belum selesai');
            $table->timestamp('tglpengumpulantugas')->nullable();
            $table->timestamp('tglpenilaian')->nullable();
            $table->integer('nilaitugas')->nullable();
            $table->enum('statuspenilaian', ['belum dinilai', 'sudah dinilai'])->default('belum dinilai');
            $table->string('catatantugas')->nullable();
            $table->timestamp('tglcatatantugas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugasbelajar');
    }
};
