<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('organizer')->orderBy('event_date', 'asc')->paginate(10);
        return view('events.index', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'is_online' => 'boolean',
            'meeting_link' => 'nullable|url',
        ]);

        $request->user()->eventsOrganized()->create($validated);

        return back()->with('status', 'Event created successfully!');
    }

    public function register(Event $event)
    {
        if ($event->isRegisteredBy(Auth::user())) {
            $event->registrations()->where('user_id', Auth::id())->delete();
            return back()->with('status', 'Unregistered from event.');
        }

        $event->registrations()->create(['user_id' => Auth::id()]);
        
        return back()->with('status', 'Successfully registered for event!');
    }
}
