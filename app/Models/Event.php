<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'event_date',
        'location',
        'is_online',
        'meeting_link',
        'cover_image',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'is_online' => 'boolean',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function isRegisteredBy(User $user): bool
    {
        return $this->registrations()->where('user_id', $user->id)->exists();
    }
}
