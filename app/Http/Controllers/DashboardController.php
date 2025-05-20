<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\LeaveRequest;
use App\Models\Working_hour;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $workingHours = Working_hour::first();
        $checkIn = Carbon::parse($workingHours->check_in);

        // Time thresholds
        $presentStart = $checkIn->copy()->subMinutes(10);
        $presentEnd = $checkIn->copy()->addMinutes(10);
        $lateEnd = $checkIn->copy()->addMinutes(60);

        // Monthly attendance summary
        $attendance = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get()
            ->map(function ($record) use ($presentStart, $presentEnd, $lateEnd) {
                $record->status = $this->determineStatus($record->check_in, $presentStart, $presentEnd, $lateEnd);
                return $record;
            });

        $presentDays = $attendance->where('status', 'present')->count();
        $lateDays = $attendance->where('status', 'late')->count();
        $absentDays = $attendance->where('status', 'absent')->count();

        // Vacation data
        $totalVacationDays = Leave::where('user_id', $user->id)->value('total_leave') ?? 21;

        $usedVacationDays = LeaveRequest::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereYear('start_date', $now->year)
            ->get()
            ->sum(function ($leave) {
                return Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1;
            });

        $remainingVacationDays = $totalVacationDays - $usedVacationDays;

        // Recent attendance
        $recentAttendance = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get()
            ->map(function ($record) use ($presentStart, $presentEnd, $lateEnd) {
                $record->status = $this->determineStatus($record->check_in, $presentStart, $presentEnd, $lateEnd);
                return $record;
            });

        return view('dashboard.index', compact(
            'presentDays',
            'lateDays',
            'absentDays',
            'usedVacationDays',
            'remainingVacationDays',
            'totalVacationDays',
            'recentAttendance'
        ));
    }

    private function determineStatus($checkInValue, $presentStart, $presentEnd, $lateEnd)
    {
        if (!$checkInValue) {
            return 'absent';
        }

        $clockIn = Carbon::parse($checkInValue);

        if ($clockIn->between($presentStart, $presentEnd)) {
            return 'present';
        } elseif ($clockIn->greaterThan($presentEnd) && $clockIn->lessThanOrEqualTo($lateEnd)) {
            return 'late';
        }

        return 'absent';
    }
}
