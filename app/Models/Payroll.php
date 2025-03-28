<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'user_id', 'pay_month', 'basic_salary',
        'bonus', 'deductions', 'net_salary', 'payment_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adjustments()
    {
        return $this->hasMany(PayrollAdjustment::class);
    }
    
}
