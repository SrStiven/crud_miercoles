<?php

namespace Database\Seeders;

use App\Models\Books;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BooksSeeder extends Seeder
{

    public function run(): void
    {
        $faker = Faker::create();

        for($i=0;$i < 20;$i++){
            Books::create([
                'name' => $faker->name,
                'title' => $faker->sentence(3),
                'count' => $faker->numberBetween(0,100),
                'gender' => $faker->randomElement(['ficcion', 'comedia', 'accion'])
            ]);
        }
    }
}
