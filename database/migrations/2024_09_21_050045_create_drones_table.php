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
        Schema::create('drones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status');
            $table->string('brand');
            $table->string('model');
            $table->string('type');
            $table->string('description');
            $table->foreignId('inventory_id')->constrainedTo('inventory')->cascadeDelete();
            $table->foreignId('extraInformation_id')->constarinedTo('drone_extra_information')->cascadeDelete();
            $table->foreignId('connection_id')->constrainedTo('drone_connection')->cascadeDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drones');
    }
};
