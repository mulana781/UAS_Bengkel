<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 528; $i++) {
            Customer::create([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
            ]);
        }
    }
} 