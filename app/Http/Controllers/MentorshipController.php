<?php

namespace App\Http\Controllers;

use App\Models\Mentorship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorshipController extends Controller
{
    public function request(Request $request, User $alumni)
    {
        // Ensure the target is actually an alumni
        if ($alumni->role !== 'alumni') {
            return back()->with('error', 'You can only request mentorship from alumni.');
        }

        // Prevent self-mentorship
        if (Auth::id() === $alumni->id) {
            return back()->with('error', 'You cannot mentor yourself.');
        }

        Mentorship::firstOrCreate([
            'mentee_id' => Auth::id(),
            'mentor_id' => $alumni->id,
        ], [
            'status' => 'pending',
            'request_message' => $request->input('message', 'I would love to be mentored by you!'),
        ]);

        return back()->with('status', 'Mentorship request sent successfully!');
    }

    public function approve(Mentorship $mentorship)
    {
        // Only the designated mentor can approve
        abort_if($mentorship->mentor_id !== Auth::id(), 403);

        $mentorship->update(['status' => 'active']);

        return back()->with('status', 'Mentorship approved!');
    }
}
