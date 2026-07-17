<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    protected $fillable = [
        'department_id',
        'created_by',
        'title',
        'description',
        'requirements',
        'status',
        'rejection_reason',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function applications()
    {
        // Preparing for Task 4
        return $this->hasMany(Application::class);
    }
}
