<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('categories')->truncate();
        DB::table('events')->truncate();
        DB::table('ticket_types')->truncate();
        DB::table('bookings')->truncate();
        DB::table('booking_cancellations')->truncate();


        $this->call(UserSeeder::class);
        $this->call(RandomUserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(EventSeeder::class);
        $this->call(TicketTypeSeeder::class);
    }
}
