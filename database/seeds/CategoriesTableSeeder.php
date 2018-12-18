<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // "Inspired" by eat.ch categories...
        $data = [
            ['name' => 'African'],
            ['name' => 'American'],
            ['name' => 'Chinese'],
            ['name' => 'Curry'],
            ['name' => 'Greek'],
            ['name' => 'Indian'],
            ['name' => 'Italian'],
            ['name' => 'Japanese'],
            ['name' => 'Kebab'],
            ['name' => 'Mexican'],
            ['name' => 'Oriental'],
            ['name' => 'Pizzas'],
            ['name' => 'Swiss'],
            ['name' => 'Thai'],
            ['name' => 'Vegan'],
            ['name' => 'Vegetarian'],
        ];

        DB::table('categories')->insert($data);
    }
}
