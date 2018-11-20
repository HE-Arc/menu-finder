<?php

namespace App\Http\Controllers;

use App\Dish;
use App\Menu;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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
        return view('menu.index')
            ->with(['toto' => 'salut tlm']);
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
        $items = $restaurants->pluck('name', 'id')->toArray();
/*
        $starters = $request->old('starter1');
        $main = $request->old('dish');
        $dessert = $request->old('dessert1');
        var_dump($starters);
        var_dump($main);
        var_dump($dessert);*/


        return view('menu.create')
            ->with(['menu' => $menu,
                    'items' => $items]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
            'start' => 'required|date',
            'end' => 'required|date',
            'dish' => 'required|array|min:1',
            'categories' => 'required',
            'price' => 'required',
        ]);
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

            foreach ($request['dish'] as $key => $val) {
                Dish::create([
                    'name' => $val,
                    'type' => 'main',
                    'menu_id' => $menu->id  ,
                ]);
            }
            foreach ($request['starter'] as $key => $val) {
                Dish::create([
                    'name' => $val,
                    'type' => 'starter',
                    'menu_id' => $menu->id,
                ]);
            }
            foreach ($request['dessert'] as $key => $val) {
                Dish::create([
                    'name' => $val,
                    'type' => 'dessert',
                    'menu_id' => $menu->id,
                ]);
            }
            $message = 'The menu '. $menu->name . ' has been created!';
            return redirect()
                ->action('MenuController@index')
                ->with(['succesMessage' => $message,
                ]);
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $errorInfo = $exception->getMessage();
            $errorMessage = 'There was an error please try again';
            return redirect()
                ->action('MenuController@create')
                ->withInput()
                ->withErrors(['errorInfo' => $errorMessage]);
            //TODOS use old value for dishes
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
