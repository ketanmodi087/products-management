<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            Product::create([
                'name' => $faker->words(3, true),
                'price' => $faker->randomFloat(2, 10, 1000),
            ]);
        }
    }
}
