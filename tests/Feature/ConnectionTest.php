<?php

namespace Tests\Feature;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConnectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_connection_request()
    {
        $requester = User::factory()->create();
        $receiver = User::factory()->create();

        $response = $this->actingAs($requester)->post('/connections', [
            'receiver_id' => $receiver->id,
        ]);

        $this->assertDatabaseHas('connections', [
            'requester_id' => $requester->id,
            'receiver_id' => $receiver->id,
            'status' => 'pending',
        ]);
    }

    public function test_user_can_accept_connection_request()
    {
        $requester = User::factory()->create();
        $receiver = User::factory()->create();
        
        $connection = Connection::factory()->create([
            'requester_id' => $requester->id,
            'receiver_id' => $receiver->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($receiver)->patch("/connections/{$connection->id}/accept");

        $this->assertDatabaseHas('connections', [
            'id' => $connection->id,
            'status' => 'accepted',
        ]);
    }

    public function test_user_can_reject_connection_request()
    {
        $requester = User::factory()->create();
        $receiver = User::factory()->create();
        
        $connection = Connection::factory()->create([
            'requester_id' => $requester->id,
            'receiver_id' => $receiver->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($receiver)->delete("/connections/{$connection->id}/reject");

        $this->assertDatabaseMissing('connections', [
            'id' => $connection->id,
            'status' => 'pending',
        ]);
    }
}
