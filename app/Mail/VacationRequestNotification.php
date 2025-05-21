<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\LeaveRequest;
use App\Models\User;

class VacationRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $leaveRequest;
    public $employee;

    /**
     * Create a new message instance.
     */
    public function __construct(LeaveRequest $leaveRequest, User $employee)
    {
        $this->leaveRequest = $leaveRequest;
        $this->employee = $employee;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Leave Request from ' . $this->employee->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.vacation-request',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
