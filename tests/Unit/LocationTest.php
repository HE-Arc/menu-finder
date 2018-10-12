<?php

namespace Tests\Unit;

use App\Location;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Phaza\LaravelPostgis\Geometries\Point;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use DatabaseTransactions;

    public function testLocationAllWithinRadiusGreatDistance()
    {
        $latCdf = 47.103287;
        $lngCdf = 6.832455;

        $data = [];

        $this->addTestData(
            $data,
            Location::create([
                'name' => 'La Chaux-de-Fonds',
                'position' => new Point(47.055591, 6.745454),
            ]),
            10
        );

        $this->addTestData(
            $data,
            Location::create([
                'name' => 'Neuchâtel',
                'position' => new Point(46.989986, 6.929273),
            ]),
            50
        );

        $this->addTestData(
            $data,
            Location::create([
                'name' => 'Zürich',
                'position' => new Point(47.376888, 8.541694),
            ]),
            200
        );
//
        $this->addTestData(
            $data,
            Location::create([
                'name' => 'Londres',
                'position' => new Point(51.507320, -0.127647),
            ]),
            1000
        );

        $this->addTestData(
            $data,
            Location::create([
                'name' => 'GooglePlex',
                'position' => new Point(40.925575, -111.887381),
            ]),
            10000
        );

        $this->assertTestData($data, $latCdf, $lngCdf);
    }

    public function testLocationAllWithinRadiusShortDistance()
    {
        $latEcole = 46.997649;
        $lngEcole = 6.938739;
        // Measured with Google Maps
        $data = [];

        $this->addTestData(
            $data,
            Location::create([
                'name' => 'King Food',
                'position' => new Point(46.997290, 6.937626),
            ]),
            0.1
        );

        $this->addTestData(
            $data,
            Location::create([
                'name' => 'Restaurant Mei-Jing',
                'position' => new Point(46.996285, 6.936003),
            ]),
            0.3
        );

        $this->addTestData(
            $data,
            Location::create([
                'name' => 'Next Stop',
                'position' => new Point(46.996926, 6.934067),
            ]),
            0.4
        );

        $this->addTestData(
            $data,
            Location::create([
                'name' => 'Bleu Café',
                'position' => new Point(46.993397, 6.935144),
            ]),
            0.6
        );

        $this->addTestData(
            $data,
            Location::create([
                'name' => 'Fleur-de-Lys',
                'position' => new Point(46.990247, 6.930432),
            ]),
            1.1
        );

        $this->addTestData(
            $data,
            Location::create([
            'name' => 'Le Joran',
            'position' => new Point(46.981969, 6.907014),
            ]),
            3.0
        );

        $this->addTestData(
            $data,
            Location::create([
                'name' => 'Pizzeria des Allées',
                'position' => new Point(46.969143, 6.869824),
            ]),
            6.2
        );

        $this->addTestData(
            $data,
            Location::create([
                'name' => 'Le Maillard',
                'position' => new Point(47.099969, 6.781670),
            ]),
            16.5
        );

        $this->addTestData(
            $data,
            Location::create([
                'name' => 'La Table de Mary',
                'position' => new Point(46.781988, 6.667808),
            ]),
            32.0
        );

        $this->assertTestData($data, $latEcole, $lngEcole);
    }

    private function addTestData(array &$data, Location $location, $distance)
    {
        $data[] = [
            'location' => $location,
            'distance' => $distance,
        ];
    }

    private function assertTestData(array $data, $lat, $lng)
    {
        $emptyResult = Location::allWithinRadius($lat, $lng, 0);
        $this->assertCount(0, $emptyResult);

        foreach ($data as $index => $wrapper) {
            $distance = $wrapper['distance'];
            $results = Location::allWithinRadius($lat, $lng, $distance);

            $this->assertCount($index + 1, $results);

            for ($i = 0; $i < $index; $i++) {
                $location = $data[$i]['location'];
                $this->assertTrue($results->contains($location->id));
            }
        }
    }
}
