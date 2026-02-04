<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GreenhouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a default user if none exists
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // 2. Create a Default Plant
        $plant = \App\Models\GreenhousePlant::firstOrCreate(
            ['user_id' => $user->id, 'name' => 'Main Greenhouse'],
            ['location' => 'Backyard', 'description' => 'Primary monitoring unit']
        );

        // 3. Ensure the 3 required devices exist for this plant
        $deviceTypes = ['AC', 'FAN', 'PUMP'];
        foreach ($deviceTypes as $type) {
            \App\Models\Device::firstOrCreate(
                ['plant_id' => $plant->id, 'type' => $type],
                ['mode' => 'AUTO', 'status' => false]
            );
        }

        // 4. Create default environment settings if missing
        \App\Models\UserEnvironmentSetting::firstOrCreate(
            ['user_id' => $user->id],
            [
                'plan_name' => 'Vegetable Plants',
                'temperature' => 26.00,
                'humidity' => 70.00,
                'soil_moisture' => 65.00,
                'is_customized' => false
            ]
        );
    }
}
