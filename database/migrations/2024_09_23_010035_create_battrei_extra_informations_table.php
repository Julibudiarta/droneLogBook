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
        Schema::create('battrei_extra_informations', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date');
            $table->integer('insurable_value');
            $table->integer('wight');
            $table->string('firmware_version');
            $table->string('hardware_version');
            $table->boolean('is_loaner')->default(false);
            $table->string('description');
            $table->foreignId('owner_id')->constrainedTo('users')->cascadeDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battrei_extra_informations');
    }
};
