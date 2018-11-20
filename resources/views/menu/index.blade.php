@extends('layouts.app')

@section('content')
<h1>Menu View</h1>
@if(session('succesMessage'))
    <div class="alert alert-success">
        {{session('succesMessage')}}
    </div>
    </div>
@endif
@endsection