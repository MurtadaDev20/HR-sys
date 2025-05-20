<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Working_hour;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{



    public function markAttendance(Request $request)
    {
        $user = auth()->user();
        $deviceId = $request->device_id;

        // Assign device if first time
        if (!$user->device_id) {
            $user->device_id = $deviceId;
            $user->save();
        }

        // Block unauthorized devices
        if ($user->device_id !== $deviceId) {
            return response()->json(['message' => 'Unauthorized device.'], 403);
        }

        $today = now()->toDateString();
        $now = now();

        // Get official working check-in time (example: 08:00:00)
        $workingHours = Working_hour::first();
        $officialCheckIn = Carbon::createFromTimeString($workingHours->check_in);
        $checkoutThreshold = $officialCheckIn->copy()->addHours(2); // example: 10:00

        // Get or create attendance
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {

            if ($checkoutThreshold) {
                 // First scan → check-in
            Attendance::create([
                'user_id' => $user->id,
                'date' => $today,
                'check_out' => $now,
                'status' => 'present',
            ]);
            return response()->json(['message' => '✅ Check-out recorded at ' . $now->format('H:i')]);
            }else{
                // First scan → check-in
            Attendance::create([
                'user_id' => $user->id,
                'date' => $today,
                'check_in' => $now,
                'status' => 'present',
            ]);
            return response()->json(['message' => '✅ Check-in recorded at ' . $now->format('H:i')]);
            }
        }

        // Already checked out
        if ($attendance->check_out) {
            return response()->json(['message' => '⚠️ Already checked out at ' . Carbon::parse($attendance->check_out)->format('H:i')]);
        }

        // Allow check-out only if 2 hours or more passed since official check-in time
        if ($now->gte($checkoutThreshold)) {
            $attendance->update(['check_out' => $now]);
            return response()->json(['message' => '✅ Check-out recorded at ' . $now->format('H:i')]);
        }

        // Still early
        $minutesRemaining = $now->diffInMinutes($checkoutThreshold);
        return response()->json(['message' => '⏳ You can check out in ' . $minutesRemaining . ' minute(s).']);
    }



}
