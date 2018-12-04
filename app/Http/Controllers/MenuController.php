<?php

namespace App\Http\Controllers;

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
        $restaurants = $currentUser->restaurants;
        $menus = $restaurants[0]->menus;
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
        $currentUser = \Auth::user();
        $restaurants = $currentUser->restaurants;
        $restaurantItems = $restaurants->pluck('name', 'id')->toArray();

        return view('menu.create')
            ->with(['menu' => $menu,
                    'items' => $restaurantItems]);
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

        $this->validate($request, [
            'restaurant' => 'required',
            'name' => 'required|max:255',
            'start' => 'required|date|after:yesterday',
            'end' => 'required|date|after_or_equal:start',
            'dish' => 'required|array|min:1',
            'categories' => 'required',
            'price' => 'required',
        ]);
            $menu = null;
            try {
                $menu = Menu::create([
                    'name' => $request->name,
                    'price' => $request->price,
                    'start' => $request->start,
                    'end' => $request->end,
                    'restaurant_id' => $request->restaurant,
                    'category_id' => 1,
                    'active' => true,
                ]);

                $this->createDish($request, $menu->id);

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
                //$errorMessage = $exception->getMessage();
                $errorMessage = 'There was an error please try again';
                return redirect()
                    ->action('MenuController@create')
                    ->withInput()
                    ->withErrors(['errorInfo' => $errorMessage]);
            }

    }

    /**
     * @param Request $request
     * @param $id
     */
    public function createDish(Request $request, $menuId): void
    {
        foreach ($request['dish'] as $key => $val) {
            Dish::create([
                'name' => $val,
                'type' => 'main',
                'menu_id' => $menuId,
            ]);
        }
        foreach ($request['starter'] as $key => $val) {
            Dish::create([
                'name' => $val,
                'type' => 'starter',
                'menu_id' => $menuId,
            ]);
        }
        foreach ($request['dessert'] as $key => $val) {
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = \App\Menu::find($id);
        $currentUser = \Auth::user();
        $restaurants = $currentUser->restaurants;
        $restaurantItems = $restaurants->pluck('name', 'id')->toArray();

        return view('menu.create')
            ->with(['menu' => $menu,
                'items' => $restaurantItems]);
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

        $this->validate($request, [
            'restaurant' => 'required',
            'name' => 'required|max:255',
            'start' => 'required|date|after:yesterday',
            'end' => 'required|date|after_or_equal:start',
            'dish' => 'required|array|min:1',
            'categories' => 'required',
            'price' => 'required',
        ]);

        try {
            //Now we delete every dish from the menu an create the new one
            //Maybe check the one already existent to reduce call to db
            Dish::where('menu_id', $id)->delete();

            $menu = Menu::find($id);
            $menu->update([
                'name' => $request->name,
                'price' => $request->price,
                'start' => $request->start,
                'end' => $request->end,
                'restaurant_id' => $request->restaurant,
                'category_id' => 1,
            ]);

            $this->createDish($request, $id);

            $message = 'The menu ' . $menu->name . ' has been updated!';
            return redirect()
                ->action('MenuController@index')
                ->with(['succesMessage' => $message,
                ]);
        } catch (\Illuminate\Database\QueryException $exception) {
        //$errorMessage = $exception->getMessage();
        $errorMessage = 'There was an error please try again';
        return redirect()
            ->action('MenuController@update')
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
        try
        {
            $menu = Menu::find($id);
            $message = 'The menu ' . $menu->name . ' has been deleted!';
            $menu->delete();
            //maybe add foreign key constraints or model event
            Dish::where('menu_id', $id)->delete();

            return redirect()
                ->action('MenuController@index')
                ->with(['succesMessage' => $message,
                ]);
        }
        catch (\Illuminate\Database\QueryException $exception) {
            //$errorMessage = $exception->getMessage();
            $errorMessage = 'There was an error please try again';
            return redirect()
                ->action('MenuController@index')
                ->withInput()
                ->withErrors(['errorInfo' => $errorMessage]);
        }

    }
}
