<?php

namespace Database\Seeders;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Database\Seeder;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        if ($users->count() < 2) {
            return;
        }

        for ($i = 0; $i < 15; $i++) {
            $requester = $users->random();
            $receiver = $users->where('id', '!=', $requester->id)->random();
            
            if (!$requester || !$receiver) continue;
            
            // Check if connection already exists
            $exists = Connection::where(function($q) use ($requester, $receiver) {
                $q->where('requester_id', $requester->id)
                  ->where('receiver_id', $receiver->id);
            })->orWhere(function($q) use ($requester, $receiver) {
                $q->where('requester_id', $receiver->id)
                  ->where('receiver_id', $requester->id);
            })->exists();

            if (!$exists) {
                Connection::factory()->create([
                    'requester_id' => $requester->id,
                    'receiver_id' => $receiver->id,
                ]);
            }
        }
    }
}
