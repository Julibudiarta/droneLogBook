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
        Schema::create('drone_extra_information', function (Blueprint $table) {
            $table->id();
            $table->string('frimewareVersion');
            $table->string('hardwareVersion');
            $table->string('propulsion');
            $table->integer('capacity');
            $table->integer('wight');
            $table->string('color');
            $table->integer('maxSpeed');
            $table->integer('maxVertikalSpeed');
            $table->timestamp('maxFlightTime');
            $table->integer('maxSpeedDistance');
            $table->date('purchaseDate');
            $table->integer('insurableValue');
            $table->boolean('loanerDrone');
            $table->integer('intitialFlight');
            $table->timestamp('intitialFlightTime');
            $table->foreignId('owner_id')->constrainedTo('users')->cascadeDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drone_extra_information');
    }
};
