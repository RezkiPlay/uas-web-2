<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    protected $fillable = [
        'applicant_id',
        'document_type',
        'file_path',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
