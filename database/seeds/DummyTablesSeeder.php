<?php

use App\Category;
use App\Menu;
use App\Restaurant;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Phaza\LaravelPostgis\Geometries\Point;

class DummyTablesSeeder extends Seeder
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

        $restaurant = Restaurant::create([
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

        $category1 = Category::create([
            'name' => 'Chasse',
        ]);

        $category2 = Category::create([
            'name' => 'Végétarien'
        ]);

        $menu = Menu::create([
            'name' => 'Menu italien',
            'price' => 11.95,
            'start' => new Carbon('today midnight'),
            'end' => new Carbon('tomorrow midnight'),
            'restaurant_id' => $restaurant->id,
        ]);

        $menu->categories()->sync([$category1->id, $category2->id]);
    }
}
