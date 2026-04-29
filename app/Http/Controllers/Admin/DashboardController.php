<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_alumni' => User::where('role', 'alumni')->count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_posts' => Post::count(),
            'total_events' => Event::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
