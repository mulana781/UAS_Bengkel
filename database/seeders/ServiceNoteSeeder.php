<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceNote;
use App\Models\Service;
use Faker\Factory as Faker;

class ServiceNoteSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        // Get all services
        $services = Service::all();

        if ($services->count() > 0) {
            foreach ($services as $service) {
                // Create 1-3 notes for each service
                $numberOfNotes = rand(1, 3);
                
                for ($i = 0; $i < $numberOfNotes; $i++) {
                    ServiceNote::create([
                        'service_id' => $service->id,
                        'note' => 'Service note #' . ($i + 1) . ': ' . $faker->sentence(),
                        'cost' => $faker->numberBetween(50000, 1000000)
                    ]);
                }
            }
        }
    }
} 