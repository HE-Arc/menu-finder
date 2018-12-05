@extends('layouts.app')

@section('content')
    @php
        $old = old('dish');
        if(isset($old))
        {
            $menusByType['starter'] = old('starter') != null ? old('starter') : [""];
            $menusByType['main'] = old('dish') != null ? old('dish') : [""];
            $menusByType['dessert'] = old('dessert') != null ? old('dessert') : [""];
        }
        else
        {
            $menusByType  = $menu->all_dishes;
        }

    @endphp
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
    <h1>{{ 'Add a dish' }}</h1>

    <div class="menu-create">
        @if(isset($menu->id))
            {!! Form::model($menu, ['method' => 'PATCH', 'route' => ['menus.update', $menu->id]]) !!}
        @else
            {!! Form::model($menu, ['action' => 'MenuController@store']) !!}
        @endif
        @if($errors->has('errorInfo'))
            <div class="alert alert-warning">
                {{$errors->first('errorInfo')}}
            </div>
        @endif
        <div class="form-group row">
            {!! Form::label('restaurant', 'Restaurant', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            {!! Form::select('restaurant', $items, null, ['class' => 'form-control col-sm-10']) !!}
        </div>

        <div class="form-group row">
            {!! Form::label('name', 'Title', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            {!! Form::text('name', old('name'), ['class' => 'form-control col-sm-10']) !!}
        </div>

        @php
            $startDate = isset($menu) && $menu->start ? date($menu->start) : \Carbon\Carbon::now();
            $endDate = isset($menu) && $menu->end ? date($menu->end) : \Carbon\Carbon::now();
        @endphp
        <div class="form-group row">
            {!! Form::label('start', 'Start date', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            {!! Form::date('start', $startDate, ['class' => 'form-control col-sm-10', 'required' => 'required']) !!}
        </div>
        <div class="form-group row">
            {!! Form::label('end', 'End date', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            {!! Form::date('end', $endDate, ['class' => 'form-control col-sm-10', 'required' => 'required']) !!}
        </div>

        {{--Starters--}}
        <div id="starter-container" class="form-group row">
            {!! Form::label('starter1', 'Starter(s)', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            <div class='col-sm-10 mealInput'>
        @if(isset($menusByType['starter']) && $menusByType['starter'] != null)
            @foreach($menusByType['starter'] as $key => $starterDish)
                        <div id="starter-div1">
                            <input autocomplete="off" value="@if(is_object($starterDish)) {{$starterDish->name }} @else {{$starterDish}} @endif" class="input form-control" id="starter1" name="starter[]" type="text"
                                   placeholder="Type something"/>
                            @if ($loop->last)
                                <button class="btn add-more plusMinusBtn btn-success" type="button">+</button>
                            @else
                                <button id="remove" class="btn btn-danger remove-me plusMinusBtn" type="button">-</button>
                            @endif
                        </div>

            @endforeach
            @else
                        <div id="starter-div1">
                            <input autocomplete="off" value="" class="input form-control" id="starter1" name="starter[]" type="text"
                                   placeholder="Type something"/>
                            <button class="btn add-more plusMinusBtn btn-success" type="button">+</button>
                        </div>
        @endif
            </div>
        </div>

        {{--Main-Dish--}}
        <div id="dish-container" class="form-group row">
            {!! Form::label('dish1', 'Main(s)', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            <div class='col-sm-10 mealInput'>
        @if(isset($menusByType['main']))
            @foreach($menusByType['main'] as $key => $mainDish)
                        <div id="dish-div1">
                            <input required autocomplete="off" value="@if(is_object($mainDish)) {{$mainDish->name}} @else {{$mainDish}} @endif" class="input form-control @if($errors->has('dish')) is-invalid @endif"
                                   id="dish1" name="dish[]" type="text" placeholder="Type something"/>
                            @if ($loop->last)
                                <button class="btn add-more plusMinusBtn btn-success" type="button">+</button>
                            @else
                                <button id="remove" class="btn btn-danger remove-me plusMinusBtn" type="button">-</button>
                            @endif
                            @if($errors->has('dish'))
                                <div class="invalid-feedback">
                                    {{$errors->first('dish')}}
                                </div>
                            @endif
                        </div>
            @endforeach
        @else
                    <div id="dish-div1">
                        <input autocomplete="off" class="input form-control @if($errors->has('dish')) is-invalid @endif"
                               id="dish1" name="dish[]" type="text" placeholder="Type something"/>
                        <button class="btn add-more plusMinusBtn btn-success" type="button">+</button>
                        @if($errors->has('dish'))
                            <div class="invalid-feedback">
                                {{$errors->first('dish')}}
                            </div>
                        @endif
                    </div>
        @endif

            </div>
        </div>

        {{--Desserts--}}
        <div id="dessert-container" class="form-group row">
            {!! Form::label('dessert1', 'Dessert(s)', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            <div class='col-sm-10 mealInput'>
        @if(isset($menusByType['dessert']))
            @foreach($menusByType['dessert'] as $key => $dessertDish)
                    <div id="dessert-div1">
                        <input autocomplete="off" value="@if(is_object($dessertDish)) {{$dessertDish->name }} @else {{$dessertDish}} @endif" class="input form-control" id="dessert1" name="dessert[]" type="text"
                               placeholder="Type something"/>
                        @if ($loop->last)
                            <button class="btn add-more plusMinusBtn btn-success" type="button">+</button>
                        @else
                            <button id="remove" class="btn btn-danger remove-me plusMinusBtn" type="button">-</button>
                        @endif
                    </div>
            @endforeach
        @else
                    <div id="dessert-div1">
                        <input autocomplete="off" class="input form-control" id="dessert1" name="dessert[]" type="text"
                               placeholder="Type something"/>
                        <button class="btn add-more plusMinusBtn btn-success" type="button">+</button>
                    </div>
        @endif
            </div>
        </div>



        <div class="categories-container row">
            {!! Form::label('categories', 'Category(es)', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            {{-- @TODO Use categories model--}}
            <div class="form-check">
                {!! Form::checkbox('categories[]', '1', ['class' => 'form-check-input']) !!}
                {!! Form::label('Végétalien', null, ['class' => 'form-check-label']) !!}
            </div>
            <div class="form-check">
                {!! Form::checkbox('categories[]', '2', ['class' => 'form-check-input']) !!}
                {!! Form::label('Poisson', null, ['class' => 'form-check-label']) !!}
            </div>
            <div class="form-check">
                {!! Form::checkbox('categories[]', '3', ['class' => 'form-check-input']) !!}
                {!! Form::label('Chasse', null, ['class' => 'form-check-label']) !!}
            </div>
            <div class="form-check">
                {!! Form::checkbox('categories[]', '4', ['class' => 'form-check-input']) !!}
                {!! Form::label('Végétalien', null, ['class' => 'form-check-label']) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('price', 'Price ', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            {!! Form::number('price', old('price'), ['class' => 'form-control col-sm-10', 'required' => 'required']) !!}
        </div>
        @if(isset($menu->id))
            {!! Form::submit('Update', ['class' => 'btn btn-primary btnSubmit btn-lg btnSubmit', 'id' => 'send_button']) !!}
        @else
            {!! Form::submit('Submit', ['class' => 'btn btn-primary btnSubmit btn-lg btnSubmit', 'id' => 'send_button']) !!}
        @endif
        {!! Form::close() !!}
    </div>
@endsection