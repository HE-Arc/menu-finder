@extends('layouts.app')

@section('content')
@foreach ($errors->all() as $key => $value)
       Key: {{ $key }}
       Value: {{ $value }}
@endforeach
<h1>Ajouter un menu</h1>
<br>
<div class="menu-create">
{!! Form::open(['url' => route('menus.store'), 'method' => 'post']) !!}
    <div class="form-group row">    
    {!! Form::label('nomLbl', 'Nom', ['class' => 'col-sm-2 col-form-label col-form-label-lg']);!!}
    {!! Form::text('name', '', ['class' => 'form-control col-sm-10', 'required' => 'required']);!!}
    </div>
    
    <div class="form-group row">
    {!! Form::label('dateLbl', 'Date', ['class' => 'col-sm-2 col-form-label col-form-label-lg']);!!}
    {!! Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control col-sm-10', 'required' => 'required']);!!}
    </div>
    
    
    <div id="starter-container" class="form-group row">
    {!! Form::label('starterLbl', 'Entrée(s)', ['class' => 'col-sm-2 col-form-label col-form-label-lg']);!!}
            <div class='col-sm-10 mealInput'>            
                <div id="starter-div1">
                    <input autocomplete="off" class="input form-control" id="starter1" name="starter[]" type="text" placeholder="Type something"/>
                    <button id="b1" class="btn add-more" type="button">+</button>
                    
                </div>                         
            </div>
    </div>

    
    <div id="dish-container" class="form-group row">
    {!! Form::label('dishLbl', 'Plats(s)', ['class' => 'col-sm-2 col-form-label col-form-label-lg']);!!}
        <div class='col-sm-10 mealInput'> 
                <div id="dish-div1">
                    <input autocomplete="off" class="input form-control @if($errors->has('starter1')) is-invalid @endif" id="dish1" name="dish[]" type="text" placeholder="Type something"/>
                    <button id="b2" class="btn add-more" type="button">+</button>
                    @if($errors->has('starter1'))
                        <div class="invalid-feedback">
                            {{$errors->first('starter1')}}
                        </div>
                    @endif  
                </div> 
        </div>       
    </div>
     <div id="dessert-container" class="form-group row">
      {!! Form::label('dessertLbl', 'Dessert(s)', ['class' => 'col-sm-2 col-form-label col-form-label-lg']);!!}
      <div class='col-sm-10 mealInput'> 
                <div id="dessert-div1">
                    <input autocomplete="off" class="input form-control" id="dessert1" name="dessert[]" type="text" placeholder="Type something"/>
                    <button id="b3" class="btn add-more" type="button">+</button>
                </div>        
        </div>
    </div>
    <div class="form-group">
     {!! Form::label('categoriesLbl', 'Categorie(s)', ['class' => 'col-sm-2 col-form-label col-form-label-lg']);!!}     
     <ul>
        <li><label>{!! Form::checkbox('categories[]', 'Vegetarien', ['class' => 'form-control']);!!}Végétarien </label></li>
        <li><label>{!! Form::checkbox('categories[]', 'Vegetalien');!!}Végétalien </label></li>
        <li><label>{!! Form::checkbox('categories[]', 'Poisson');!!}Poisson </label></li>
        <li><label>{!! Form::checkbox('categories[]', 'Chasse');!!}Chasse </label></li>
        <li><label>{!! Form::checkbox('categories[]', 'Chasse');!!}Chasse </label></li>
        <li><label>{!! Form::checkbox('categories[]', 'Chasse');!!}Chasse </label></li>
        <li><label>{!! Form::checkbox('categories[]', 'Chasse');!!}Chasse </label></li>
     </ul>
     </div>
      <div class="form-group row">    
    {!! Form::label('pricelLbl', 'Prix', ['class' => 'col-sm-2 col-form-label col-form-label-lg']);!!}
    {!! Form::number('price', '', ['class' => 'form-control col-sm-10', 'required' => 'required']);!!}
    </div>
     {!! Form::submit('Envoyer', ['class' => 'btn btn-primary', 'id' => 'send_button']);!!}   
{!! Form::close() !!}
</div>
@endsection