@extends('layouts.app')

@section('content')
    <h1>{{ 'Ajouter un menu' }}</h1>
    <div class="menu-create">
        {{-- @TODO Maybe we could use Form model --}}
        {{-- @see https://laravelcollective.com/docs/5.4/html#form-model-binding --}}
        {!! Form::open(['url' => route('menus.store'), 'method' => 'post']) !!}
        <div class="form-group row">
            {!! Form::label('name', 'Nom', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            {!! Form::text('name', '', ['class' => 'form-control col-sm-10', 'required' => 'required']) !!}
        </div>

        <div class="form-group row">
            {!! Form::label('date', 'Date', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            {!! Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control col-sm-10', 'required' => 'required']) !!}
        </div>

        <div id="starter-container" class="form-group row">
            {!! Form::label('starter1', 'Entrée(s)', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            <div class='col-sm-10 mealInput'>
                <div id="starter-div1">
                    <input autocomplete="off" class="input form-control" id="starter1" name="starter[]" type="text"
                           placeholder="Type something"/>
                    <button class="btn add-more" type="button">+</button>
                </div>
            </div>
        </div>

        <div id="dish-container" class="form-group row">
            {!! Form::label('dish1', 'Plats(s)', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            <div class='col-sm-10 mealInput'>
                <div id="dish-div1">
                    <input autocomplete="off" class="input form-control @if($errors->has('dish')) is-invalid @endif"
                           id="dish1" name="dish[]" type="text" placeholder="Type something"/>
                    <button class="btn add-more" type="button">+</button>
                    @if($errors->has('dish'))
                        <div class="invalid-feedback">
                            {{$errors->first('dish')}}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div id="dessert-container" class="form-group row">
            {!! Form::label('dessert1', 'Dessert(s)', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            <div class='col-sm-10 mealInput'>
                <div id="dessert-div1">
                    <input autocomplete="off" class="input form-control" id="dessert1" name="dessert[]" type="text"
                           placeholder="Type something"/>
                    <button class="btn add-more" type="button">+</button>
                </div>
            </div>
        </div>

        <div class="categories-container row">
            {!! Form::label('categories', 'Categorie(s)', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
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
            {!! Form::label('price', 'Prix', ['class' => 'col-sm-2 col-form-label col-form-label-lg']) !!}
            {!! Form::number('price', '', ['class' => 'form-control col-sm-10', 'required' => 'required']) !!}
        </div>

        {!! Form::submit('Envoyer', ['class' => 'btn btn-primary', 'id' => 'send_button']) !!}
        {!! Form::close() !!}
    </div>
@endsection