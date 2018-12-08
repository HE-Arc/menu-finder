<?php

use App\Restaurant;
use App\User;
use Illuminate\Database\Seeder;
use Phaza\LaravelPostgis\Geometries\Point;

class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = User::create([
            'name' => 'JohnDoe',
            'password' => 'password',
            'email' => 'fake-owner@example.com',
        ]);

        Restaurant::create([
            'name' => 'King Food',
            'active' => true,
            'rate_sum' => 15,
            'rate_nb' => 3,
            'location' => new Point(46.997290, 6.937626),
            'address' => 'Place de l\'Europe 7',
            'city' => 'Neuchâtel',
            'zip' => 2300,
            'website' => 'http://www.king-food.ch/',
            'user_id' => $owner->id,
        ]);
    }
}
