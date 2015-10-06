<?php

use Illuminate\Database\Seeder;

class ShirtsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shirtCount = 20;
        $faker = Faker\Factory::create('pl_PL');
        for($i=0; $i<$shirtCount; $i++) {
            \ShirtBase\Shirt::create([
                'name' => $faker->lexify('?????????'),
                'user_id' => 1,
                'size' => $faker->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XXL']),
                'photo' => 'sample/TShirt'.rand(1,4).'.jpg',
                'color_id' => rand(1,140),
                'comfortability' => rand(1,10),
                'wear' => rand(1,10),
                'sleeve_length' => rand(5,100),
                'notes' => $faker->paragraph
            ]);
        }
    }
}
