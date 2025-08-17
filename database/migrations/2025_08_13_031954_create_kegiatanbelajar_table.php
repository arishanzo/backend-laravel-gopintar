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
        Schema::create('kegiatanbelajar', function (Blueprint $table) {
            $table->id('idkegiatanbelajar');
            $table->integer('iduser')->unique();
            $table->integer('idguru')->unique();
            $table->string('fotokegiatan')->nullable();
            $table->string('videokegiatan')->nullable();
            $table->string('linkmateri')->nullable();
            $table->string('namakegiatan')->nullable();
            $table->text('deskripsikegiatan')->nullable();
            $table->timestamp('tglkegiatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatanbelajar');
    }
};
