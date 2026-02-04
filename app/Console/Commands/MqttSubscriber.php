<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use PhpMqtt\Client\Facades\MQTT;
use App\Models\SensorReading;
use App\Services\AutomationService;

class MqttSubscriber extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe to MQTT sensor topics and process data';

    public function handle()
    {
        $mqtt = MQTT::connection();

        $mqtt->subscribe('greenhouse/sensors/+', function (string $topic, string $message) {
            $this->info("Received message on topic [$topic]: $message");

            // Extract user_id from topic: greenhouse/sensors/{user_id}
            $topicParts = explode('/', $topic);
            $userId = end($topicParts);

            $data = json_decode($message, true);

            if ($data) {
                $reading = SensorReading::create([
                    'user_id' => $userId,
                    'temperature' => $data['temperature'] ?? 0,
                    'humidity' => $data['humidity'] ?? 0,
                    'soil_moisture' => $data['soil_moisture'] ?? 0,
                ]);

                // Trigger automation logic
                $automation = new AutomationService();
                $automation->check($reading);
            }
        }, 0);

        $mqtt->loop(true);
    }
}
