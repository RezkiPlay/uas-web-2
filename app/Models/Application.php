<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'job_posting_id',
        'applicant_id',
        'status',
        'applied_at',
    ];

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(ApplicationStatusLog::class)->latest();
    }

    public function interviewSchedule()
    {
        return $this->hasOne(InterviewSchedule::class);
    }

    public function assessmentResult()
    {
        return $this->hasOne(AssessmentResult::class);
    }
}
