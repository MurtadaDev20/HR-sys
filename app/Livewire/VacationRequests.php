<?php

namespace App\Livewire;

use App\Models\LeaveRequest;
use Livewire\Component;

class VacationRequests extends Component
{
    public $requests;
    public $search = '';
    public $filter = 'all';
    public $selectedRequest = null;
    public $showModal = false;

    public function mount()
    {
        $this->loadRequests();
    }

    public function loadRequests()
{
    $user = auth()->user();

    if ($user->role === 'manager') {
        // Get departments managed by this user
        $departmentIds = \App\Models\Department::where('manager_id', $user->id)->pluck('id');

        // Get leave requests from employees in those departments
        $this->requests = LeaveRequest::with('user.department')
            ->where('status', 'pending')
            ->whereHas('user', function ($query) use ($departmentIds) {
                $query->where('role', 'employee')
                      ->whereIn('department_id', $departmentIds);
            })
            ->get()
            ->map(function ($req) {
                return [
                    'id' => $req->id,
                    'employeeName' => $req->user->name,
                    'department' => $req->user->department->name ?? '—',
                    'startDate' => $req->start_date,
                    'endDate' => $req->end_date,
                    'duration' => \Carbon\Carbon::parse($req->start_date)->diffInDays($req->end_date) + 1,
                    'reason' => $req->reason,
                    'status' => $req->status,
                ];
            });
    } else {
        // Optionally return nothing or only self data
        $this->requests = collect();
    }
}

    public function getFilteredRequestsProperty()
    {
        return $this->requests->filter(function ($r) {
            $matchesSearch = str_contains(strtolower($r['employeeName']), strtolower($this->search)) ||
                             str_contains(strtolower($r['department']), strtolower($this->search));

            $matchesFilter = $this->filter === 'all' || $r['status'] === $this->filter;

            return $matchesSearch && $matchesFilter;
        });
    }

    public function show($id)
    {
        $this->selectedRequest = $this->requests->firstWhere('id', $id);
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
        $this->selectedRequest = null;
    }

    public function approve()
    {
        $leaveRequest = LeaveRequest::find($this->selectedRequest['id']);
        $leaveRequest->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->user()->id,

        ]);

        $this->selectedRequest['status'] = 'approved';
        $this->close();
    }

    public function reject()
    {
        $this->selectedRequest['status'] = 'rejected';
        $this->close();
    }

    public function render()
    {
        return view('livewire.vacation-requests');
    }
}
