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
        Schema::create('aduan', function (Blueprint $table) {
            $table->id('idaduan');
            $table->integer('iduser')->unique();
            $table->integer('idguru')->unique();
            $table->string('juduladuan')->nullable();
            $table->text('deskripsiaduan')->nullable();
            $table->enum('statusaduan', ['ditanggapi', 'belum ditanggapi', 'ditolak'])->default('belum ditanggapi');
            $table->timestamp('tgladuan')->nullable();
            $table->text('tanggapan')->nullable();
            $table->timestamp('tgltanggapan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduan');
    }
};
