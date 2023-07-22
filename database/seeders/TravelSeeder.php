<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TravelSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Generate 10 random travel records
        for ($i = 0; $i < 10; $i++) {
            DB::table('travel')->insert([
                'price' => $faker->numberBetween(500000, 1200000),
                'origin' => $faker->city,
                'destination' => $faker->city,
                'departure_time' => $faker->dateTimeBetween('+1 week', '+1 month'),
                'user_id' => 1, // Replace with the appropriate user_id
                'is_available' => $faker->boolean,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
