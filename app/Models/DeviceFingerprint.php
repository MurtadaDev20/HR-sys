<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceFingerprint extends Model
{
    protected $fillable = [
        'user_id',
        'fingerprint',
        'device_info',
        'last_used_at',
        'is_trusted'
    ];

    protected $casts = [
        'device_info' => 'array',
        'last_used_at' => 'datetime',
        'is_trusted' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
