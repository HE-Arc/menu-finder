@extends('layouts.app')

@section('content')
@foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
@endforeach
@if(isset($restaurant->id))
    {!! Form::model($restaurant, ['method' => 'PATCH', 'route' => ['restaurants.update', $restaurant->id], 'id' => 'form-restaurant-update']) !!}
@else
    {!! Form::model($restaurant, ['action' => 'RestaurantController@store', 'id' => 'form-restaurant-update']) !!}
@endif
<div class="row">
  <div class="col-md-9">
    <div class="form-group">
      <div class="mb-3">
        <label for="validationDefault01">Restaurant name</label>
        <input name="name" type="text" value="{{ old('name', $restaurant->name) }}" class="form-control" id="validationDefault01" placeholder="Restaurant name" required>
      </div>
    </div>
  <div class="form-row">
    <div class="col mb-3">
      <label for="validationDefault02">Address</label>
      <input name="address" type="text" value="{{ old('address', $restaurant->address) }}" class="form-control" id="validationDefault02" placeholder="Address" required>
    </div>
    <div class="col mb-3">
      <label for="validationDefault03">City</label>
      <input name="city" type="text" value="{{ old('city', $restaurant->city) }}" class="form-control" id="validationDefault03" placeholder="City" required>
    </div>
    <div class="col mb-3">
      <label for="validationDefault04">Zip</label>
      <input name="zip" type="number" value="{{ old('zip', $restaurant->zip) }}" class="form-control" id="validationDefault04" placeholder="Zip" required>
    </div>
  </div>
  <div class="form-group">
    <div class="mb-3">
      <label for="validationDefault05">Website</label>
      <input name="website" type="text" value="{{ old('website', $restaurant->website) }}" class="form-control" id="validationDefault05" placeholder="Website" required>
    </div>
  </div>
  <div class="form-group">
    <div class="mb-3">
      <label for="validationDefault06">Description</label>
      <textarea name="description"  class="form-control" rows="3" id="validationDefault06" placeholder="Description" required>{{ old('description', $restaurant->description) }}</textarea>

    </div>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group row">
      <div>
        <label for="profile-picture-input" class="col-md-4 col-form-label text-md-right">Picture</label>

          <img id="current-avatar" src="{{ $restaurant->avatar_url }}">

          <input type="hidden" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}" name="avatar" id="avatar">

          <div id="profile-picture-preview" style="display:inline-block"></div>

          @if ($errors->has('avatar'))
              <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('avatar') }}</strong>
          </span>
          @endif

      </div>
      <div id="button-browse">
        <label class="btn btn-primary btn-file">
            {{ 'Parcourir' }} <input id="profile-picture-upload" type="file" style="display: none;" accept="image/*">
        </label>
      </div>


  </div>

</div>
@if(isset($restaurant->id))
    {!! Form::submit('Update', ['class' => 'btn btn-primary btnSubmit btn-lg btnSubmit', 'id' => 'send_button']) !!}
@else
    {!! Form::submit('Submit', ['class' => 'btn btn-primary btnSubmit btn-lg btnSubmit', 'id' => 'send_button']) !!}
@endif
{!! Form::close() !!}

</div>
@endsection
