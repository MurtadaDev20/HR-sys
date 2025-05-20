<?php

namespace App\Http\Controllers;

use App\Models\DeviceFingerprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceVerificationController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'fingerprint' => 'required|string',
            'device_info' => 'nullable|array'
        ]);

        $user = Auth::user();
        $fingerprint = $request->fingerprint;

        // Check if this device is already registered
        $device = DeviceFingerprint::where('user_id', $user->id)
            ->where('fingerprint', $fingerprint)
            ->first();

        if ($device) {
            // Update last used timestamp
            $device->update([
                'last_used_at' => now(),
                'device_info' => $request->device_info
            ]);
            return response()->json(['verified' => true, 'is_trusted' => $device->is_trusted]);
        }

        // If this is a new device, create a record
        $newDevice = DeviceFingerprint::create([
            'user_id' => $user->id,
            'fingerprint' => $fingerprint,
            'device_info' => $request->device_info,
            'last_used_at' => now(),
            'is_trusted' => false // New devices are not trusted by default
        ]);

        return response()->json(['verified' => false, 'is_trusted' => false]);
    }

    public function trustDevice(Request $request)
    {
        $request->validate([
            'fingerprint' => 'required|string'
        ]);

        $device = DeviceFingerprint::where('user_id', Auth::id())
            ->where('fingerprint', $request->fingerprint)
            ->firstOrFail();

        $device->update(['is_trusted' => true]);

        return response()->json(['message' => 'Device marked as trusted']);
    }
}
