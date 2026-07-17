<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferLetter extends Model
{
    protected $fillable = [
        'application_id',
        'salary_offered',
        'join_date',
        'status',
        'file_path'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
