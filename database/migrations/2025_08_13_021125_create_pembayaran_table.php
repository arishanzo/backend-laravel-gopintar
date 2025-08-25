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
                $table->unsignedBigInteger('iduser')->unique();
            $table->string('order_id')->unique();
            $table->string('transaction_id');
            $table->string('namapaket')->nullable();
            $table->string('metodepembayaran')->nullable(); // bank_transfer, qris, gopay, dll
            $table->decimal('jumlahpembayaran', 12, 2);
            $table->string('statuspembayaran')->default('pending');
            $table->dateTime('tglberakhirpembayaran')->nullable();

            // detail tambahan sesuai metode
            $table->string('va_number')->nullable();       // bank transfer
            $table->string('bank')->nullable();            // bank bca, bri, dll
            $table->text('qris_url')->nullable();          // url QRIS
            $table->string('payment_code')->nullable();    // kode cstore
            $table->text('redirect_url')->nullable();      // credit_card / ewallet

            $table->timestamps();


             $table->foreign('iduser')->references('iduser')->on('userlogin')->onDelete('cascade');
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
