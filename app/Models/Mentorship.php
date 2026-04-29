<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentorship extends Model
{
    protected $fillable = [
        'mentor_id',
        'mentee_id',
        'status',
        'goals',
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function mentee()
    {
        return $this->belongsTo(User::class, 'mentee_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
