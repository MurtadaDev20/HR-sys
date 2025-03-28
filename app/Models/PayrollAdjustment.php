<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollAdjustment extends Model
{
    protected $fillable = ['payroll_id', 'type', 'label', 'amount'];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
