<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user if one doesn't exist
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'name' => 'System Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }

        // Create sample organizers
        if (User::where('role', 'organizer')->count() < 3) {
            User::create([
                'name' => 'Event Organizer One',
                'email' => 'organizer1@example.com',
                'password' => Hash::make('password123'),
                'role' => 'organizer',
                'email_verified_at' => now(),
            ]);

            User::create([
                'name' => 'Event Organizer Two',
                'email' => 'organizer2@example.com',
                'password' => Hash::make('password123'),
                'role' => 'organizer',
                'email_verified_at' => now(),
            ]);
        }

        // Create sample regular users
        if (User::where('role', 'user')->count() < 5) {
            User::create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);

            User::create([
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);

            User::create([
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
        }
    }
}
