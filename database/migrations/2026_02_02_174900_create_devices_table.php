<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained('greenhouse_plants')->onDelete('cascade');
            $table->enum('type', ['AC', 'FAN', 'PUMP']);
            $table->enum('mode', ['ON', 'OFF', 'AUTO'])->default('AUTO');
            $table->boolean('status')->default(false); // false = OFF, true = ON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
