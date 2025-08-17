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
        Schema::create('bookingdate', function (Blueprint $table) {
            $table->id('idbookingdate');
            $table->integer('iduser')->unique();
            $table->integer('idguru')->unique();
            $table->integer('idbookingprivate')->unique();
            $table->date('tanggal');
            $table->enum('statusngajar', ['selesai', 'batal', 'pending'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookingdate');
    }
};
