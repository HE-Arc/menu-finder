<?php

namespace Tests\Feature;

use App\Category;
use App\Menu;
use App\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuApiTest extends JsonApiTestCase
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
    protected $resourceType = 'menus';

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
        $menu = Menu::all()->first();
        $expected = $this->serialize($menu);

        $this->doRead($menu)->assertRead($expected);
    }

    /**
     * @param Category $menu
     * @return array
     */
    private function serialize(Menu $menu)
    {
        $self = "http://localhost/api/beta/menus/{$menu->getKey()}";

        return [
            'type' => 'menus',
            'id' => (string) $menu->getRouteKey(),
            'attributes' => [
                'name' => $menu->name,
                'price' => $menu->price,
                'start' => $menu->start->toIso8601String(),
                'end' => $menu->end->toIso8601String(),
                'active' => $menu->active,
            ],
            'links' => [
                'self' => $self,
            ],
        ];
    }
}
