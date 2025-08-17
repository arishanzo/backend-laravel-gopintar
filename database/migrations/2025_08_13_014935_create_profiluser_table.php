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
        Schema::create('profiluser', function (Blueprint $table) {
            $table->id('idprofiluser');
            $table->integer('iduser')->unique();
            $table->string('foto_profil')->nullable();
            $table->string('alamatlengkap')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->integer('kode_pos')->nullable();
            $table->string('nama_anak')->nullable();
            $table->string('usia_anak')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiluser');
    }
};
