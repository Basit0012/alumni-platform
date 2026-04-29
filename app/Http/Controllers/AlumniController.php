<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'alumni')->with('profile');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('batch') && $request->batch != '') {
            $query->whereHas('profile', function($q) use ($request) {
                $q->where('batch_year', $request->batch);
            });
        }

        $alumni = $query->paginate(12);
        
        // Get unique batches for the filter dropdown
        $batches = \App\Models\Profile::whereNotNull('batch_year')
                    ->whereHas('user', function($q) {
                        $q->where('role', 'alumni');
                    })
                    ->distinct()
                    ->pluck('batch_year')
                    ->sort()
                    ->reverse();

        return view('alumni.index', compact('alumni', 'batches'));
    }
}
