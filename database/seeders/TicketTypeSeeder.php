<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all available event IDs
        $eventIds = Event::pluck('id')->toArray();

        // If no events exist, warn and exit
        if (empty($eventIds)) {
            $this->command->warn('No events found. Please run EventSeeder first or ensure events exist in the database.');
            return;
        }

        $this->command->info("Found " . count($eventIds) . " events. Creating ticket types...");

        // Get tickettype data from the file
        $tickettypes = require database_path('seeders/data/tickettype.php');

        // Shuffle event IDs to ensure good distribution
        shuffle($eventIds);

        foreach ($tickettypes as $index => $tickettype) {
            // Assign a random event_id from available events
            // Cycle through events to ensure each event gets at least one ticket type
            $eventIndex = $index % count($eventIds);
            $tickettype['event_id'] = $eventIds[$eventIndex];

            // Create the ticket type 
            TicketType::create($tickettype);

            $this->command->info("✓ Created ticket type '{$tickettype['name']}' for event ID {$tickettype['event_id']}");
        }
    }
}
