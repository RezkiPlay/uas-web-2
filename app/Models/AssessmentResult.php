<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentResult extends Model
{
    protected $fillable = [
        'application_id',
        'score',
        'hr_notes'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
