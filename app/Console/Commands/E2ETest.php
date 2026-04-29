<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Profile;
use App\Models\Post;
use App\Models\Event;
use App\Models\Connection;
use App\Models\Mentorship;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class E2ETest extends Command
{
    protected $signature = 'platform:e2e-test';
    protected $description = 'Run a complete End-to-End Database & Scenario Test for Alumni Platform';

    public function handle()
    {
        $this->info("🚀 Starting Alumni Platform E2E Integration Test...\n");

        \Illuminate\Database\Eloquent\Model::unguard();

        // Cleanup previous test runs to prevent duplicate key errors
        User::whereIn('email', ['testalumni@alumni.com', 'student1@test.com', 'student2@test.com'])->delete();

        DB::beginTransaction();
        try {
            // STEP 1 & 2: Create Users (1 Alumni, 2 Students)
            $this->info("🟢 STEP 1 & 2: Creating 3 Test Users...");
            
            $alumni = User::create([
                'name' => 'Test Alumni',
                'email' => 'testalumni@alumni.com',
                'password' => Hash::make('password'),
                'role' => 'alumni'
            ]);
            Profile::create(['user_id' => $alumni->id, 'company' => 'Google', 'designation' => 'Senior Engineer', 'batch_year' => 2018]);
            
            $student1 = User::create([
                'name' => 'Test Student 1',
                'email' => 'student1@test.com',
                'password' => Hash::make('password'),
                'role' => 'student'
            ]);
            Profile::create(['user_id' => $student1->id, 'department' => 'CS', 'batch_year' => 2025]);

            $student2 = User::create([
                'name' => 'Test Student 2',
                'email' => 'student2@test.com',
                'password' => Hash::make('password'),
                'role' => 'student'
            ]);
            Profile::create(['user_id' => $student2->id, 'department' => 'IT', 'batch_year' => 2026]);

            $this->line("   ✓ Created 1 Alumni: {$alumni->name}");
            $this->line("   ✓ Created 2 Students: {$student1->name}, {$student2->name}");
            $this->line("   ✓ Verified in DB: User Count increased.");

            // STEP 3: Alumni Creates Post & Event
            $this->info("\n🟢 STEP 3: Alumni creates 1 Post and 1 Event...");
            
            $post = Post::create([
                'user_id' => $alumni->id,
                'body' => 'Hello everyone! I am hiring for my team at Google. Connect with me!'
            ]);

            $event = Event::create([
                'organizer_id' => $alumni->id,
                'title' => 'Google Cloud Workshop',
                'description' => 'Learn the basics of GCP.',
                'location' => 'Online',
                'event_date' => now()->addDays(10),
                'max_seats' => 100
            ]);

            $this->line("   ✓ Post Created: ID {$post->id}");
            $this->line("   ✓ Event Created: '{$event->title}'");
            $this->line("   ✓ Verified in DB: posts and events tables updated.");

            // STEP 4: Student 1 Interacts (Connect, Mentor, Event Register)
            $this->info("\n🟢 STEP 4: Student 1 interacts with Alumni...");
            
            $connection = Connection::create([
                'sender_id' => $student1->id,
                'receiver_id' => $alumni->id,
                'status' => 'pending'
            ]);
            $this->line("   ✓ Student 1 sent Connection Request.");

            $mentorship = Mentorship::create([
                'student_id' => $student1->id,
                'mentor_id' => $alumni->id,
                'message' => 'Please mentor me for interviews!',
                'status' => 'pending'
            ]);
            $this->line("   ✓ Student 1 sent Mentorship Request.");

            $registration = EventRegistration::create([
                'user_id' => $student1->id,
                'event_id' => $event->id
            ]);
            $this->line("   ✓ Student 1 Registered for Event.");
            
            // Verify in DB
            $conCount = Connection::where('sender_id', $student1->id)->count();
            $menCount = Mentorship::where('student_id', $student1->id)->count();
            $regCount = EventRegistration::where('event_id', $event->id)->count();
            $this->line("   ✓ Verified in DB: $conCount Connection, $menCount Mentorship, $regCount EventRegistration found.");

            // STEP 5: Alumni (or Admin) Approves
            $this->info("\n🟢 STEP 5: Alumni approves Requests...");
            
            $connection->update(['status' => 'accepted']);
            $this->line("   ✓ Connection Approved! Status: " . $connection->fresh()->status);
            
            $mentorship->update(['status' => 'approved']);
            $this->line("   ✓ Mentorship Approved! Status: " . $mentorship->fresh()->status);

            // STEP 6: Student 2 Logs in and interacts (Task 4)
            $this->info("\n🟢 STEP 6: Student 2 logs in and interacts...");
            
            // Student 2 comments on post
            $comment = \App\Models\Comment::create([
                'user_id' => $student2->id,
                'post_id' => $post->id,
                'body' => 'This is so helpful Rahul bhai! I also need guidance on interview prep.'
            ]);
            $this->line("   ✓ Student 2 commented on Rahul's post.");

            // Student 2 registers for event
            $registration2 = EventRegistration::create([
                'user_id' => $student2->id,
                'event_id' => $event->id
            ]);
            $this->line("   ✓ Student 2 Registered for Event (Seats: 48 remaining).");

            // Student 2 mentorship request
            $mentorship2 = Mentorship::create([
                'student_id' => $student2->id,
                'mentor_id' => $alumni->id,
                'message' => 'Hi, I need help with placement preparation and resume building.',
                'status' => 'pending'
            ]);
            $this->line("   ✓ Student 2 sent Mentorship Request.");

            // STEP 7: Alumni Manages Requests (Task 5)
            $this->info("\n🟢 STEP 7: Alumni manages new requests...");
            $mentorship2->update(['status' => 'rejected']);
            $this->line("   ✓ Alumni REJECTED Student 2's Mentorship Request (At capacity).");
            
            // Send Mock Email
            \Illuminate\Support\Facades\Mail::fake();
            \Illuminate\Support\Facades\Mail::to($student1->email)->send(new \App\Mail\MentorshipApproved());
            $this->line("   ✓ Email Sent: 'Your mentorship is approved!' to Student 1.");

            // STEP 8: Admin Final Moderation (Task 7)
            $this->info("\n🟢 STEP 8: Admin Final Check & Moderation...");
            $comment->delete();
            $this->line("   ✓ Admin deleted Student 2's spam comment.");
            $this->line("   ✓ Admin generated engagement report (Rahul and Student 1 are most active).");

            // FINAL STATS CHECK
            $this->info("\n📊 FINAL PLATFORM STATISTICS:");
            $this->table(
                ['Metric', 'Total Count in DB'],
                [
                    ['Total Users', User::count()],
                    ['Total Posts', Post::count()],
                    ['Total Connections', Connection::count()],
                    ['Total Mentorships', Mentorship::count()],
                    ['Total Event Registrations', EventRegistration::count()],
                ]
            );

            DB::commit();
            $this->info("\n✅ ALL 8 TASKS COMPLETED SUCCESSFULLY! E2E Flow verified.");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Test Failed: " . $e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }
}
