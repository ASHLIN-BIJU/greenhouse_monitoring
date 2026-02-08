<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceSetting;
use Illuminate\Support\Facades\Auth;
class DeviceSettingController extends Controller
{
    public function save(Request $request)
    {
        $data = $request->validate([
            'ac_mode' => 'required|in:on,off,auto',
            'exhaust_mode' => 'required|in:on,off,auto',
            'pump_mode' => 'required|in:on,off,auto',
            
        ]);

        DeviceSetting::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        return response()->json(['message' => 'Settings saved']);
    }
}
