<?php

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // http://dixitpatel.com/how-to-seed-database-from-json-in-laravel/
    public function run()
    {
        DB::table('colors')->truncate();

        $colorsJsonSource = File::get(storage_path('seed_data/css-color-names.json'));
        $colorsArray = json_decode($colorsJsonSource);

        foreach ($colorsArray as $name => $hexCode) {
            \ShirtBase\Color::create([
                'name' => $name,
                'hexCode' => $hexCode
            ]);
        }

    }
}
