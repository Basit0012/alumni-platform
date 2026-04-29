<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function send(Request $request, User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot connect with yourself.');
        }

        Connection::firstOrCreate([
            'requester_id' => Auth::id(),
            'receiver_id' => $user->id,
        ]);

        return back()->with('status', 'Connection request sent!');
    }

    public function accept(Connection $connection)
    {
        abort_if($connection->receiver_id !== Auth::id(), 403);

        $connection->update(['status' => 'accepted']);

        return back()->with('status', 'Connection accepted!');
    }

    public function reject(Connection $connection)
    {
        abort_if($connection->receiver_id !== Auth::id(), 403);

        $connection->delete();

        return back()->with('status', 'Connection rejected!');
    }
}
