<?php

namespace App\Http\Controllers;

use App\Category;
use App\Dish;
use App\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = \Auth::user();
        $restaurant = $currentUser->restaurant;
        $menus = null;
        if (isset($restaurant)) {
            $menus = $restaurant->menus->load('categories', 'dishes');
        }
        return view('menu.index')
            ->with(['menus' => $menus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $menu = new Menu();
        $categories = Category::all();
        $restaurant = \Auth::user()->restaurant;
         if($restaurant == null) {
             return redirect()
                 ->action('MenuController@index');
                 }
        return view('menu.create')
            ->with(['menu' => $menu,
                    'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param if updating the id of the menu
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'starter' => array_filter($request->input('starter'), array($this, 'filterArrayNullValue')),
            'dish' => array_filter($request->input('dish'), array($this, 'filterArrayNullValue')),
            'dessert' => array_filter($request->input('dessert'), array($this, 'filterArrayNullValue')),
        ]);

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'start' => 'required|date|after:yesterday',
            'end' => 'required|date|after_or_equal:start',
            'dish' => 'required|array|min:1',
            'starter' => 'sometimes|array',
            'dessert' => 'sometimes|array',
            'categories' => 'sometimes|array',
            'price' => 'required',
        ]);


            $menu = null;
        try {
            $categoriesId = null;
            if (isset($validatedData['categories'])) {
                $categoriesId = array_map('intval', $validatedData['categories']);
            }

            $currentUser = \Auth::user();

            $menu = Menu::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'start' => $validatedData['start'],
                'end' => $validatedData['end'],
                'restaurant_id' => $currentUser->restaurant->id,
                'active' => true,
            ]);
            if ($categoriesId != null) {
                $menu->categories()->sync($categoriesId);
            }

            $this->createDish($validatedData, $menu->id);

            $message = 'The menu ' . $menu->name . ' has been created!';
            return redirect()
                ->action('MenuController@index')
                ->with(['succesMessage' => $message,
                ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($menu != null) {
                    Dish::where('menu_id', $menu->id)->delete();
                    Menu::find($menu->id)->delete();
            }
              $errorMessage = $exception->getMessage();
              //$errorMessage = 'There was an error please try again';
              return redirect()
                  ->action('MenuController@create')
                  ->withInput()
                  ->withErrors(['errorInfo' => $errorMessage]);
        }
    }

      /**
       * @param $validatedRequest
       * @param $request
       * @param $menuId
       */
    public function createDish($validatedRequest, $menuId): void
    {
        foreach ($validatedRequest['dish'] as $key => $val) {
            Dish::create([
                'name' => $val,
                'type' => 'main',
                'menu_id' => $menuId,
            ]);
        }
        foreach ($validatedRequest['starter'] as $key => $val) {
            Dish::create([
                'name' => $val,
                'type' => 'starter',
                'menu_id' => $menuId,
            ]);
        }
        foreach ($validatedRequest['dessert'] as $key => $val) {
            Dish::create([
                'name' => $val,
                'type' => 'dessert',
                'menu_id' => $menuId,
            ]);
        }
    }

    private function filterArrayNullValue($value)
    {
        return $value != null;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::find($id);
        $categories = Category::all();

        return view('menu.create')
            ->with(['menu' => $menu,
                'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->merge([
            'starter' => array_filter($request->input('starter'), array($this, 'filterArrayNullValue')),
            'dish' => array_filter($request->input('dish'), array($this, 'filterArrayNullValue')),
            'dessert' => array_filter($request->input('dessert'), array($this, 'filterArrayNullValue')),
        ]);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'start' => 'required|date|after:yesterday',
            'end' => 'required|date|after_or_equal:start',
            'dish' => 'required|array|min:1',
            'starter' => 'sometimes|array',
            'dessert' => 'sometimes|array',
            'categories' => 'sometimes|array',
            'price' => 'required',
        ]);

        try {
            //Now we delete every dish from the menu an create the new one
            //Maybe check the one already existent
            Dish::where('menu_id', $id)->delete();

            $currentUser = \Auth::user();

            $categoriesId = null;
            if (isset($validatedData['categories'])) {
                $categoriesId = array_map('intval', $validatedData['categories']);
            }

            $menu = Menu::find($id);
            $menu->update([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'start' => $validatedData['start'],
                'end' => $validatedData['end'],
                'restaurant_id' => $currentUser->restaurant->id,
                'active' => true,
            ]);

            if ($categoriesId != null) {
                $menu->categories()->sync($categoriesId);
            } else {
                $menu->categories()->detach();
            }

            $this->createDish($validatedData, $id);

            $message = 'The menu ' . $menu->name . ' has been updated!';
            return redirect()
                ->action('MenuController@index')
                ->with(['succesMessage' => $message,
                ]);
        } catch (\Illuminate\Database\QueryException $exception) {
        //$errorMessage = $exception->getMessage();
            $errorMessage = 'There was an error please try again';
            return redirect()
            ->back()
            ->withInput()
            ->withErrors(['errorInfo' => $errorMessage]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $menu = Menu::find($id);
            $message = 'The menu ' . $menu->name . ' has been deleted!';
            $menu->categories()->detach();
            $menu->delete();
            //maybe add foreign key constraints or model event
            Dish::where('menu_id', $id)->delete();

            return redirect()
                ->action('MenuController@index')
                ->with(['succesMessage' => $message,
                ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            //$errorMessage = $exception->getMessage();
            $errorMessage = 'There was an error please try again';
            return redirect()
                ->action('MenuController@index')
                ->withInput()
                ->withErrors(['errorInfo' => $errorMessage]);
        }
    }
}
