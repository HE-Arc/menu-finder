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
        $categoryTest1 = Category::create([
            'name' => 'test',
        ]);

        $categoryTest2 = Category::create([
            'name' => 'test2',
        ]);
        $categoryTest3 = Category::create([
            'name' => 'test3',
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

        $menuTest1 = Menu::create([
            'name' => 'menuTest',
            'restaurant_id' => $restaurantTest->id,
        ]);
        $menuTest1->categories()->attach([
           $categoryTest1->id,
           $categoryTest2->id,
        ]);
        $menuTest2 = Menu::create([
            'name' => 'menuTest2',
            'restaurant_id' => $restaurantTest->id,
        ]);
        $menuTest2->categories()->attach([
            $categoryTest1->id,
            $categoryTest3->id,
        ]);
        
        $dishTest = Dish::create([
            'name' => 'dishTest',
            'menu_id' => $menuTest1->id,
        ]);

        // Test one-to-many relations
        $this->assertTrue($userTest->restaurant->is($restaurantTest));
        $this->assertTrue($restaurantTest->menus->contains($menuTest1));
        $this->assertTrue($menuTest1->dishes->contains($dishTest));

        // Test inverse one-to-many relations
        $this->assertTrue($restaurantTest->user->is($userTest));
        $this->assertTrue($menuTest1->restaurant->is($restaurantTest));
        $this->assertTrue($dishTest->menu->is($menuTest1));

        // Tests many-to-many relations
        $this->assertTrue($categoryTest1->menus->contains($menuTest1));
        $this->assertTrue($categoryTest2->menus->contains($menuTest1));
        $this->assertFalse($categoryTest3->menus->contains($menuTest1));
        $this->assertTrue($menuTest1->categories->contains($categoryTest1));
        $this->assertTrue($menuTest1->categories->contains($categoryTest2));
        $this->assertFalse($menuTest1->categories->contains($categoryTest3));

        $this->assertTrue($categoryTest1->menus->contains($menuTest2));
        $this->assertFalse($categoryTest2->menus->contains($menuTest2));
        $this->assertTrue($categoryTest3->menus->contains($menuTest2));
        $this->assertTrue($menuTest2->categories->contains($categoryTest1));
        $this->assertFalse($menuTest2->categories->contains($categoryTest2));
        $this->assertTrue($menuTest2->categories->contains($categoryTest3));
    }
}
