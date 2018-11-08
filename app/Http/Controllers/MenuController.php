<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
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
        return view('menu.create')
            ->with(['id' => 5]);
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
            'name' => 'required|max:255',
            'date' => 'required',
            'dish' => 'required|array|min:1',
            'categories' => 'required',
            'price' => 'required',
        ]);
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
