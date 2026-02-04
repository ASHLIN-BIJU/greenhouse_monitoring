<?php

namespace App\Http\Controllers;

use App\Models\UserEnvironmentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnvironmentController extends Controller
{
    public function selectPlan(Request $request)
    {
        $validated = $request->validate([
            'plan_name' => 'required|string|in:Herb Plants,Vegetable Plants,Flower Plants,Fruit Plants,Medicinal Plants',

        ]);

        $plans = [
            'Herb Plants' => [
                'temperature' => 22,
                'humidity' => 55,
                'soil_moisture' => 60,
            ],
            'Vegetable Plants' => [
        'temperature' => 26,
        'humidity' => 70,
        'soil_moisture' => 65,
    ],
    'Flower Plants' => [
        'temperature' => 24,
        'humidity' => 60,
        'soil_moisture' => 50,
    ],
    'Fruit Plants' => [
        'temperature' => 28,
        'humidity' => 75,
        'soil_moisture' => 70,
    ],
    'Medicinal Plants' => [
        'temperature' => 23,
        'humidity' => 65,
        'soil_moisture' => 55,
    ],
];


        $planData = $plans[$validated['plan_name']];

        $setting = UserEnvironmentSetting::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'plan_name' => $validated['plan_name'],
                'temperature' => $planData['temperature'],
                'humidity' => $planData['humidity'],
                'soil_moisture' => $planData['soil_moisture'],
                'is_customized' => false,
            ]
        );

        return response()->json([
            'message' => 'Plan selected successfully',
            'setting' => $setting
        ], 200);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'temperature' => 'required|numeric|between:0,100',
            'humidity' => 'required|numeric|between:0,100',
            'soil_moisture' => 'required|numeric|between:0,100',
        ]);

        $setting = UserEnvironmentSetting::where('user_id', Auth::id())->first();

        if (!$setting) {
            return response()->json([
                'message' => 'Please select a growing plan first before customizing settings.'
            ], 403);
        }

        $setting->update([
            'temperature' => $validated['temperature'],
            'humidity' => $validated['humidity'],
            'soil_moisture' => $validated['soil_moisture'],
            'is_customized' => true,
        ]);

        return response()->json([
            'message' => 'Settings updated successfully',
            'setting' => $setting
        ], 200);
    }

    public function getSettings()
    {
        $setting = UserEnvironmentSetting::where('user_id', Auth::id())->first();

        if (!$setting) {
            return response()->json(['message' => 'No settings found'], 404);
        }

        return response()->json($setting);
    }
}
