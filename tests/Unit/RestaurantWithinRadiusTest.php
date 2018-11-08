<?php

namespace Tests\Unit;

use App\Restaurant;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Phaza\LaravelPostgis\Geometries\Point;
use Tests\TestCase;

/**
 * Class RestaurantWithinRadiusTest
 *
 * Checks that the allWithinRadius method of Restaurant models
 * (which uses PostGis query) returns correct results.
 *
 * @package Tests\Unit
 * @see Restaurant::allWithinRadius()
 */
class RestaurantWithinRadiusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Checks that the allWithinRadius method of Restaurant models
     * (which uses PostGis query) returns correct results.
     *
     * In order to work, restaurants must be added to the data array
     * from the nearest to the furthest restaurant.
     *
     * @return void
     */
    public function testRestaurantAllWithinRadius()
    {
        // Comes from Google MAps
        $latEcole = 46.997649;
        $lngEcole = 6.938739;

        $owner = User::create([
            'name' => 'JohnDoe',
            'password' => 'password',
            'email' => 'fake-owner@example.com',
        ]);

        $data = [];

        $this->addTestData(
            $data,
            Restaurant::create([
                'name' => 'King Food',
                'location' => new Point(46.997290, 6.937626),
                'user_id' => $owner->id,
            ]),
            0.1
        );

        $this->addTestData(
            $data,
            Restaurant::create([
                'name' => 'Restaurant Mei-Jing',
                'location' => new Point(46.996285, 6.936003),
                'user_id' => $owner->id,
            ]),
            0.3
        );

        $this->addTestData(
            $data,
            Restaurant::create([
                'name' => 'Next Stop',
                'location' => new Point(46.996926, 6.934067),
                'user_id' => $owner->id,
            ]),
            0.4
        );

        $this->addTestData(
            $data,
            Restaurant::create([
                'name' => 'Bleu Café',
                'location' => new Point(46.993397, 6.935144),
                'user_id' => $owner->id,
            ]),
            0.6
        );

        $this->addTestData(
            $data,
            Restaurant::create([
                'name' => 'Fleur-de-Lys',
                'location' => new Point(46.990247, 6.930432),
                'user_id' => $owner->id,
            ]),
            1.1
        );

        $this->addTestData(
            $data,
            Restaurant::create([
                'name' => 'Le Joran',
                'location' => new Point(46.981969, 6.907014),
                'user_id' => $owner->id,
            ]),
            3.0
        );

        $this->addTestData(
            $data,
            Restaurant::create([
                'name' => 'Pizzeria des Allées',
                'location' => new Point(46.969143, 6.869824),
                'user_id' => $owner->id,
            ]),
            6.2
        );

        $this->addTestData(
            $data,
            Restaurant::create([
                'name' => 'Le Maillard',
                'location' => new Point(47.099969, 6.781670),
                'user_id' => $owner->id,
            ]),
            16.5
        );

        $this->addTestData(
            $data,
            Restaurant::create([
                'name' => 'La Table de Mary',
                'location' => new Point(46.781988, 6.667808),
                'user_id' => $owner->id,
            ]),
            32.0
        );

        $this->assertTestData($data, $latEcole, $lngEcole);
    }

    private function addTestData(array &$data, Restaurant $restaurant, $distance)
    {
        $data[] = [
            'restaurant' => $restaurant,
            'distance' => $distance,
        ];
    }

    private function assertTestData(array $data, $lat, $lng)
    {
        $emptyResult = Restaurant::allWithinRadius($lat, $lng, 0);
        $this->assertCount(0, $emptyResult);

        foreach ($data as $index => $wrapper) {
            $distance = $wrapper['distance'];
            $results = Restaurant::allWithinRadius($lat, $lng, $distance);

            $this->assertCount($index + 1, $results);

            for ($i = 0; $i < $index; $i++) {
                $restaurant = $data[$i]['restaurant'];
                $this->assertTrue($results->contains($restaurant->id));
            }
        }
    }
}
