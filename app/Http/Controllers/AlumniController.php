<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('profile')->where('role', 'alumni');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('profile', function ($pq) use ($search) {
                      $pq->where('major', 'like', "%{$search}%")
                         ->orWhere('company', 'like', "%{$search}%")
                         ->orWhere('job_title', 'like', "%{$search}%");
                  });
            });
        }

        $alumni = $query->paginate(12);

        return view('alumni.index', compact('alumni'));
    }

    public function show(User $alumnus)
    {
        abort_if($alumnus->role !== 'alumni', 404);
        
        $alumnus->load(['profile', 'posts']);
        
        return view('alumni.show', compact('alumnus'));
    }
}
