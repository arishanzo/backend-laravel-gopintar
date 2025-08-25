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
            $table->unsignedBigInteger('iduser')->unique();
            $table->unsignedBigInteger('idguru')->unique();
            $table->string('jamsesi')->nullable();
            $table->enum('statusbookingprivate', ['kelas selesai', 'kelas dimulai', 'kelas belum selesai'])->default('kelas belum selesai');
            $table->timestamps();

            

             $table->foreign('iduser')->references('iduser')->on('userlogin')->onDelete('cascade');
             
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
