<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{ 
    
    protected $fillable = ['name', 'parent_id', 'manager_id'];

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    
}
