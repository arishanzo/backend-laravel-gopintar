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
        Schema::create('hasilrekapnilai', function (Blueprint $table) {
            $table->id('idhasilrekapnilai');
             $table->unsignedBigInteger('iduser')->unique();
            $table->unsignedBigInteger('idguru')->unique();
            $table->integer('idtugasbelajar')->unique();
            $table->integer('toalnilai')->nullable();
            $table->enum('statusnilai', ['selesai', 'batal', 'pending'])->default('pending');
            $table->timestamp('tglpenilaian')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            

             $table->foreign('iduser')->references('iduser')->on('userlogin')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasilrekapnilai');
    }
};
