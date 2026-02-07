<?php

namespace App\Http\Controllers;
use App\Events\SensorUpdated;
use App\Models\SensorReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SensorController extends Controller
{
    public function live(Request $request)
    {
        $data = $request->validate([
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'soil_moisture' => 'required|numeric',
        ]);

        // ✅ SAVE IN DATABASE
        $reading = SensorReading::create([
            'user_id' => Auth::id(),
            'temperature' => $data['temperature'],
            'humidity' => $data['humidity'],
            'soil_moisture' => $data['soil_moisture'],
        ]);

        // ✅ SEND LIVE (Including Target Settings)
        $settings = \App\Models\UserEnvironmentSetting::where('user_id', Auth::id())->first();

        SensorUpdated::dispatch(Auth::id(), [
            'actual' => $reading->toArray(),
            'target' => $settings ? $settings->toArray() : null
        ]);

        return response()->json([
            'message' => 'Saved + sent live',
            'reading' => $reading
        ]);
    }

    public function latest()
    {
        $reading = SensorReading::where('user_id', Auth::id())->latest()->first();
        return response()->json($reading);
    }
}
