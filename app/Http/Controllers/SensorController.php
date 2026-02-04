<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SensorReading;
use Illuminate\Support\Facades\Auth;

class SensorController extends Controller
{
    /**
     * Get historical sensor readings for the user.
     */
    public function history(Request $request)
    {
        $readings = SensorReading::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();

        return response()->json($readings);
    }

    /**
     * Get the latest sensor reading for the user.
     */
    public function realtime(Request $request)
    {
        $latest = SensorReading::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$latest) {
            return response()->json(['message' => 'No sensor data available'], 404);
        }

        return response()->json($latest);
    }

    /**
     * Manual data submission (for testing or non-MQTT devices).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'soil_moisture' => 'required|numeric',
        ]);

        $reading = SensorReading::create([
            'user_id' => Auth::id(),
            'temperature' => $validated['temperature'],
            'humidity' => $validated['humidity'],
            'soil_moisture' => $validated['soil_moisture'],
        ]);

        // Trigger automation
        (new \App\Services\AutomationService())->check($reading);

        return response()->json([
            'message' => 'Reading stored successfully',
            'reading' => $reading
        ], 201);
    }
}
