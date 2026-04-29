<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        Profile::create([
            'user_id' => $admin->id,
            'designation' => 'Administrator',
            'company' => 'Platform Inc'
        ]);

        // 5 Alumni
        User::factory()->count(5)->create(['role' => 'alumni'])->each(function ($user) {
            Profile::create([
                'user_id' => $user->id,
                'batch_year' => rand(2015, 2022),
                'company' => 'Tech Corp',
                'designation' => 'Software Engineer'
            ]);
        });

        // 10 Students
        User::factory()->count(10)->create(['role' => 'student'])->each(function ($user) {
            Profile::create([
                'user_id' => $user->id,
                'batch_year' => rand(2025, 2028),
                'department' => 'Computer Science'
            ]);
        });
    }
}
