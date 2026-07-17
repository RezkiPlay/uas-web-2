<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'summary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applicationDocuments()
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
