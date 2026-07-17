<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationStatusLog extends Model
{
    protected $fillable = [
        'application_id',
        'job_posting_id',
        'previous_status',
        'new_status',
        'changed_by',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
