<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \Illuminate\Database\Eloquent\Model::unguard();

        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            EventSeeder::class,
            // ConnectionSeeder::class, // (Temporarily disabled since schema changed)
        ]);

        \Illuminate\Database\Eloquent\Model::reguard();
    }
}
