<?php

namespace App\Jobs;

use App\Mail\VacationRequestNotification;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendVacationRequestEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $leaveRequest;
    protected $employee;
    protected $manager;

    /**
     * Create a new job instance.
     */
    public function __construct(LeaveRequest $leaveRequest, User $employee, User $manager)
    {
        $this->leaveRequest = $leaveRequest;
        $this->employee = $employee;
        $this->manager = $manager;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting to process email job', [
            'employee' => $this->employee->name,
            'manager' => $this->manager->email,
            'request_id' => $this->leaveRequest->id
        ]);

        try {
            Log::info('Attempting to send email', [
                'to' => $this->manager->email,
                'request_id' => $this->leaveRequest->id
            ]);

            Mail::to($this->manager->email)
                ->send(new VacationRequestNotification($this->leaveRequest, $this->employee));

            Log::info('Vacation request email sent successfully', [
                'employee' => $this->employee->name,
                'manager' => $this->manager->email,
                'request_id' => $this->leaveRequest->id
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send vacation request email', [
                'error' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'employee' => $this->employee->name,
                'manager' => $this->manager->email,
                'request_id' => $this->leaveRequest->id
            ]);

            // You might want to retry the job or notify an admin
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Vacation request email job failed', [
            'error' => $exception->getMessage(),
            'error_trace' => $exception->getTraceAsString(),
            'employee' => $this->employee->name,
            'manager' => $this->manager->email,
            'request_id' => $this->leaveRequest->id
        ]);
    }
}
