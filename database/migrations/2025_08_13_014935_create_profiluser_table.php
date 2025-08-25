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
            $table->unsignedBigInteger('iduser')->unique();
            $table->string('foto_profil')->nullable();
            $table->string('alamatlengkap')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('nama_anak')->nullable();
            $table->integer('usia_anak')->nullable();
            $table->timestamps();

            

             $table->foreign('iduser')->references('iduser')->on('userlogin')->onDelete('cascade');
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
