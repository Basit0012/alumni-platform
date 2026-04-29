<?php

namespace App\Http\Controllers;

use App\Models\Mentorship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MentorshipController extends Controller
{
    public function requestMentorship(Request $request, User $mentor)
    {
        abort_if($mentor->role !== 'alumni', 403, 'You can only request mentorship from alumni.');
        abort_if(Auth::id() === $mentor->id, 403, 'You cannot mentor yourself.');

        $validated = $request->validate([
            'goals' => 'required|string|max:1000',
        ]);

        $mentorship = Mentorship::create([
            'mentor_id' => $mentor->id,
            'mentee_id' => Auth::id(),
            'status' => 'pending',
            'goals' => $validated['goals'],
        ]);

        // Email Notification to Mentor
        Mail::raw("You have a new mentorship request from " . Auth::user()->name . ".\n\nGoals: " . $validated['goals'], function ($message) use ($mentor) {
            $message->to($mentor->email)
                    ->subject('New Mentorship Request - Alumni Platform');
        });

        return back()->with('status', 'Mentorship request sent successfully!');
    }

    public function approve(Mentorship $mentorship)
    {
        abort_if($mentorship->mentor_id !== Auth::id(), 403);

        $mentorship->update(['status' => 'active']);

        // Email Notification to Mentee
        Mail::raw("Great news! Your mentorship request has been approved by " . Auth::user()->name . ".", function ($message) use ($mentorship) {
            $message->to($mentorship->mentee->email)
                    ->subject('Mentorship Request Approved - Alumni Platform');
        });

        return back()->with('status', 'Mentorship request approved.');
    }

    public function reject(Mentorship $mentorship)
    {
        abort_if($mentorship->mentor_id !== Auth::id(), 403);

        $mentorship->update(['status' => 'rejected']);

        return back()->with('status', 'Mentorship request rejected.');
    }
}
