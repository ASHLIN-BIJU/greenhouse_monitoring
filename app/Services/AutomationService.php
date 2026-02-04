<?php

namespace App\Services;

use App\Models\SensorReading;
use App\Models\Device;
use App\Models\UserEnvironmentSetting;
use App\Models\Notification;

class AutomationService
{
    public function check(SensorReading $reading)
    {
        // Get user settings (requested plan or customized values)
        $settings = UserEnvironmentSetting::where('user_id', $reading->user_id)->first();

        if (!$settings) {
            return;
        }

        // Logic for AC (Temperature)
        $this->controlDevice($reading->user_id, 'AC', $reading->temperature > $settings->temperature);

        // Logic for Fan (Humidity)
        $this->controlDevice($reading->user_id, 'FAN', $reading->humidity > $settings->humidity);

        // Logic for Pump (Soil Moisture)
        $this->controlDevice($reading->user_id, 'PUMP', $reading->soil_moisture < $settings->soil_moisture);
    }

    private function controlDevice($userId, $type, $shouldBeOn)
    {
        // For simplicity, we assume one device per type per user for now
        // In a full implementation, it would be linked to a specific plant_id
        $device = Device::whereHas('plant', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('type', $type)->where('mode', 'AUTO')->first();

        if ($device && $device->status != $shouldBeOn) {
            $device->update(['status' => $shouldBeOn]);

            // Create notification
            Notification::create([
                'user_id' => $userId,
                'plant_id' => $device->plant_id,
                'title' => "Device Alert: {$type}",
                'body' => "Device {$type} has been turned " . ($shouldBeOn ? 'ON' : 'OFF') . " automatically.",
                'type' => 'automation'
            ]);

            // Publish command TO MQTT for ESP32 to act
            try {
                \PhpMqtt\Client\Facades\MQTT::publish("greenhouse/devices/{$userId}/{$type}", $shouldBeOn ? 'ON' : 'OFF');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Failed to publish to MQTT: " . $e->getMessage());
            }
        }
    }
}
