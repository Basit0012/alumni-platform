<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Event;
use App\Models\Connection;
use App\Models\Mentorship;
use App\Models\EventRegistration;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'alumni' => User::where('role', 'alumni')->count(),
            'students' => User::where('role', 'student')->count(),
            'posts' => Post::count(),
            'events' => Event::count(),
            'connections' => Connection::count(),
            'mentorships' => Mentorship::count(),
            'pending_mentorships' => Mentorship::where('status', 'pending')->count(),
            'pending_connections' => Connection::where('status', 'pending')->count(),
        ];

        $recentUsers = User::with('profile')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
}
