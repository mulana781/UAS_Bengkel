<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\Customer;
use Faker\Factory as Faker;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $customers = Customer::all();

        // Create 1-3 vehicles for each customer
        foreach ($customers as $customer) {
            $numberOfVehicles = rand(1, 3);
            
            for ($i = 0; $i < $numberOfVehicles; $i++) {
                Vehicle::create([
                    'customer_id' => $customer->id,
                    'brand' => $faker->randomElement(['Toyota', 'Honda', 'Suzuki', 'Daihatsu', 'Mitsubishi']),
                    'model' => $faker->randomElement(['Avanza', 'Xenia', 'Jazz', 'Brio', 'Ertiga', 'Innova']),
                    'year' => $faker->numberBetween(2010, 2024),
                    'license_plate' => strtoupper($faker->randomLetter . ' ' . rand(1000, 9999) . ' ' . $faker->randomLetter . $faker->randomLetter)
                ]);
            }
        }
    }
} 