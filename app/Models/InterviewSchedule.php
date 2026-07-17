<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewSchedule extends Model
{
    protected $fillable = [
        'application_id',
        'schedule_time',
        'location_or_link',
        'notes'
    ];

    protected $casts = [
        'schedule_time' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
