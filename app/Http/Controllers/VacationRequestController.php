<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use App\Jobs\SendVacationRequestEmail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        $leaveRequest = LeaveRequest::create([
            'user_id' => auth()->id(),
            'leave_type_id' => $validated['vacationType'],
            'start_date' => $validated['startDate'],
            'end_date' => $validated['endDate'],
            'days' => $days,
            'note' => $validated['reason'],
            'status' => 'pending'
        ]);

        // Get the employee's manager
        $employee = auth()->user();
        $manager = User::find($employee->manager_id);

        // Dispatch the email job if manager exists
        if ($manager) {
            Log::info('Dispatching email job', [
                'employee' => $employee->name,
                'manager' => $manager->email,
                'request_id' => $leaveRequest->id
            ]);

            SendVacationRequestEmail::dispatch($leaveRequest, $employee, $manager);
        }

        return redirect()->route('vacation-request')
            ->with('success', 'Vacation request submitted successfully!');
    }
}
