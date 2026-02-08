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
        Schema::create('device_settings', function (Blueprint $table) {
            $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->enum('ac_mode', ['on','off','auto'])->default('auto');
        $table->enum('exhaust_mode', ['on','off','auto'])->default('auto');
        $table->enum('pump_mode', ['on','off','auto'])->default('auto');

        $table->float('target_temp')->default(50);
        $table->float('target_humidity')->default(60);
        $table->float('target_soil')->default(70);

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_settings');
    }
};
