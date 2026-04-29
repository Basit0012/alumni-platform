<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'avatar',
        'headline',
        'company',
        'job_title',
        'graduation_year',
        'major',
        'bio',
        'linkedin_url',
        'github_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
