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
        Schema::create('bookingprivate', function (Blueprint $table) {
            $table->id('idbookingprivate');
            $table->integer('iduser')->unique();
            $table->integer('idguru')->unique();
            $table->string('jamsesi')->nullable();
            $table->enum('statusbookingprivate', ['kelas selesai', 'kelas dimulai', 'kelas belum selesai'])->default('kelas belum selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookingprivate');
    }
};
