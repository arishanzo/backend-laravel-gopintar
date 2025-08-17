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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('idpembayaran');
             $table->integer('iduser')->unique();
            $table->string('namapaket')->nullable();
            $table->timestamp('tglberakhirpembayaran')->nullable();
            $table->timestamp('metodepembayaran')->nullable();
            $table->integer('jumlahpembayaran')->nullable();
            $table->enum('statuspembayaran', ['pending', 'berhasil', 'gagal'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
