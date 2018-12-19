<?php

namespace Tests\Feature;

use App\Category;
use App\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestaurantApiTest extends JsonApiTestCase
{
    use RefreshDatabase;

    /**
     * The API to test, if empty uses the default API.
     *
     * @var string
     */
    protected $api = 'beta';

    /**
     * @var string
     */
    protected $resourceType = 'restaurants';

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * Test the read resource route.
     */
    public function testRead()
    {
        $restaurant = Restaurant::all()->first();
        $expected = $this->serialize($restaurant);

        $this->doRead($restaurant)->assertRead($expected);
    }

    /**
     * @param Category $restaurant
     * @return array
     */
    private function serialize(Restaurant $restaurant)
    {
        $self = "http://localhost/api/beta/restaurants/{$restaurant->getKey()}";

        return [
            'type' => 'restaurants',
            'id' => (string) $restaurant->getRouteKey(),
            'attributes' => [
                'name' => $restaurant->name,
                'active' => $restaurant->active,
                'rate' => $restaurant->rate,
                'location' => [
                    'lat' => $restaurant->lat,
                    'lng' => $restaurant->lng,
                ],
                'address' => $restaurant->address,
                'zip' => $restaurant->zip,
                'city' => $restaurant->city,
                'avatar' => $restaurant->avatar_url,
                'website' => $restaurant->website,
                'description' => $restaurant->description,
            ],
            'links' => [
                'self' => $self,
            ],
        ];
    }
}
