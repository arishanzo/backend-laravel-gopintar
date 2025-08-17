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
        Schema::create('feedbackbelajar', function (Blueprint $table) {
            $table->id('idfeedbackbelajar');
             $table->integer('iduser')->unique();
            $table->integer('idguru')->unique();
            $table->integer('idbookingprivate')->unique();
            $table->string('feedbackbelajar')->nullable();
            $table->integer('ratingbelajar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbackbelajar');
    }
};
