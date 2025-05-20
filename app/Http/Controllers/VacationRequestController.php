<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Carbon\Carbon;
class VacationRequestController extends Controller
{
    public function index()
    {
         // Vacation data
         $totalVacationDays = Leave::where('user_id', auth()->user()->id)->value('total_leave') ?? 21;

         $usedVacationDays = LeaveRequest::where('user_id', auth()->user()->id)
             ->where('status', 'approved')
             ->whereYear('start_date', now()->year)
             ->get()
             ->sum(function ($leave) {
                 return Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1;
             });

         $remainingVacationDays = $totalVacationDays - $usedVacationDays;
        $typeVacation = LeaveType::all();
        return view('employ.vacation-request', compact('typeVacation', 'totalVacationDays', 'usedVacationDays', 'remainingVacationDays'));
    }
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'vacationType' => 'required|exists:leave_types,id',
            'reason' => 'required|string|max:500'
        ]);

        // Calculate duration in days
        $startDate = \Carbon\Carbon::parse($validated['startDate']);
        $endDate = \Carbon\Carbon::parse($validated['endDate']);
        $days = $startDate->diffInDays($endDate) + 1;

        // Create the vacation request
        $vacationRequest = \App\Models\LeaveRequest::create([
            'user_id' => auth()->id(),
            'leave_type_id' => $validated['vacationType'],
            'start_date' => $validated['startDate'],
            'end_date' => $validated['endDate'],
            'days' => $days,
            'note' => $validated['reason'],
            'status' => 'pending'
        ]);

        return redirect()->route('vacation-request')
            ->with('success', 'Vacation request submitted successfully!');
    }
}
