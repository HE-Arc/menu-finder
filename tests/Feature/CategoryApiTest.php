<?php

namespace Tests\Feature;

use App\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryApiTest extends JsonApiTestCase
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
    protected $resourceType = 'categories';

    /**
     * Test the read resource route.
     */
    public function testRead()
    {
        $category = Category::create([
            'name' => 'Chasse',
        ]);

        $expected = $this->serialize($category);

        $this->doRead($category)->assertRead($expected);
    }

    /**
     * @param Category $category
     * @return array
     */
    private function serialize(Category $category)
    {
        $self = "http://localhost/api/beta/categories/{$category->getKey()}";

        return [
            'type' => 'categories',
            'id' => (string) $category->getRouteKey(),
            'attributes' => [
                'name' => $category->name,
            ],
            'links' => [
                'self' => $self,
            ],
        ];
    }
}
