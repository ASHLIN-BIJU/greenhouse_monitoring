<?php

namespace App\Http\Controllers;
use App\Events\SensorUpdated;
use App\Models\SensorReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DeviceSetting;
use App\Models\UserEnvironmentSetting;

class SensorController extends Controller
{
    public function live(Request $request)
{
    $data = $request->validate([
        'temperature' => 'required|numeric',
        'humidity' => 'required|numeric',
        'soil_moisture' => 'required|numeric',
    ]);

    $reading = SensorReading::create([
        'user_id' => Auth::id(),
        ...$data
    ]);

    $targets = UserEnvironmentSetting::where('user_id', Auth::id())->first();
    $modes = DeviceSetting::where('user_id', Auth::id())->first();

    $actions = [];

    // AC
    if ($modes->ac_mode === 'auto') {
        $actions['ac'] = $data['temperature'] > $targets->temperature ? 'ON' : 'OFF';
    } else {
        $actions['ac'] = strtoupper($modes->ac_mode);
    }

    // Exhaust
    if ($modes->exhaust_mode === 'auto') {
        $actions['exhaust'] = $data['humidity'] > $targets->humidity ? 'ON' : 'OFF';
    } else {
        $actions['exhaust'] = strtoupper($modes->exhaust_mode);
    }

    // Pump
    if ($modes->pump_mode === 'auto') {
        $actions['pump'] = $data['soil_moisture'] < $targets->soil_moisture ? 'ON' : 'OFF';
    } else {
        $actions['pump'] = strtoupper($modes->pump_mode);
    }

    return response()->json([
        'sensor' => $reading,
        'actions' => $actions
    ]);
}
}