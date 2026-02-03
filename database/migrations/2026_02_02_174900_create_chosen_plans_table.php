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
        Schema::create('chosen_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained('greenhouse_plants')->onDelete('cascade');
            $table->foreignId('plan_type_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('min_temp', 5, 2);
            $table->decimal('max_temp', 5, 2);
            $table->decimal('min_humidity', 5, 2);
            $table->decimal('max_humidity', 5, 2);
            $table->decimal('min_soil_moisture', 5, 2);
            $table->decimal('max_soil_moisture', 5, 2);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chosen_plans');
    }
};
