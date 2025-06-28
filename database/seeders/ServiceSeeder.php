<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Vehicle;
use Faker\Factory as Faker;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $vehicles = Vehicle::all();
        
        $serviceTypes = [
            'Oil Change',
            'Brake Service',
            'Tire Rotation',
            'Engine Tune-up',
            'Battery Replacement',
            'Air Filter Replacement',
            'Transmission Service',
            'Wheel Alignment'
        ];

        // Create 1-5 services for each vehicle
        foreach ($vehicles as $vehicle) {
            $numberOfServices = rand(1, 5);
            
            for ($i = 0; $i < $numberOfServices; $i++) {
                Service::create([
                    'vehicle_id' => $vehicle->id,
                    'service_type' => $faker->randomElement($serviceTypes),
                    'description' => $faker->paragraph,
                    'service_date' => $faker->dateTimeBetween('-6 months', 'now'),
                    'status' => $faker->randomElement(['pending', 'in_progress', 'completed']),
                    'price' => $faker->numberBetween(100000, 5000000),
                    'cost' => $faker->numberBetween(50000, 500000),
                ]);
            }
        }
    }
} 