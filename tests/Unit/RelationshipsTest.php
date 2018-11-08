<?php

namespace Tests\Unit;

use App\Category;
use App\User;
use App\Restaurant;
use App\Menu;
use App\Dish;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RelationshipsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Tests that Eloquent relationships works as expected.
     *
     * @return void
     */
    public function testModels()
    {
        // Set up dummy data
        $categoryTest = Category::create([
            'name' => 'test',
        ]);

        $userTest = User::create([
            'name' => 'userTest',
            'password' => '1234',
            'email' => 'foo@test.com',
        ]);

        $restaurantTest = Restaurant::create([
            'name' => 'restaurantTest',
            'user_id' => $userTest->id,
        ]);

        $menuTest = Menu::create([
            'name' => 'menuTest',
            'restaurant_id' => $restaurantTest->id,
            'category_id' => $categoryTest->id,

        ]);

        $dishTest = Dish::create([
            'name' => 'dishTest',
            'menu_id' => $menuTest->id,
        ]);

        // Test one-to-many relations
        $this->assertTrue($userTest->restaurants->contains($restaurantTest));
        $this->assertTrue($restaurantTest->menus->contains($menuTest));
        $this->assertTrue($categoryTest->menus->contains($menuTest));
        $this->assertTrue($menuTest->dishes->contains($dishTest));

        // Test inverse one-to-many relations
        $this->assertTrue($restaurantTest->user->is($userTest));
        $this->assertTrue($menuTest->restaurant->is($restaurantTest));
        $this->assertTrue($menuTest->category->is($categoryTest));
        $this->assertTrue($dishTest->menu->is($menuTest));
    }
}
