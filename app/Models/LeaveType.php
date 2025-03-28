<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = ['name', 'max_days'];

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
