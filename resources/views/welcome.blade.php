@extends('layouts.app')

@section('content')

{{--<!doctype html>--}}
{{--<html lang="{{app()->getLocale()}}">--}}
{{--<head>--}}
    {{--<meta charset="utf-8">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    {{--<title>Menu Finder</title>--}}
    {{--<!-- Fonts -->--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">--}}
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--</head>--}}
{{--<body>--}}
<div class="parallax"></div>
<div class="flex-center position-ref">
    {{--@if (Route::has('login'))--}}
        {{--<div class="top-right links">--}}
            {{--@auth--}}
                {{--<a class="float-right links" href="{{ url('/restaurants') }}">My restaurants</a>--}}
            {{--@else--}}
                {{--<div class="float-right links">--}}
                {{--<a  href="{{ route('login') }}">Login</a>--}}
                {{--<a  href="{{ route('register') }}">Register</a>--}}
                {{--</div>--}}
            {{--@endauth--}}

        {{--</div>--}}
    {{--@endif--}}

    <div class="content welcomeText">
        <div class="title m-b-md">
            Restaurants
        </div>
        <img src="/asset/sharp-restaurant-24px.svg" class="rounded mx-auto d-block icon" alt="Restaurant">
    </div>
    <div class="content welcomeText">
        <div class="title m-b-md ">
            Menus
        </div>
        <img src="/asset/sharp-restaurant_menu-24px.svg" class="rounded mx-auto d-block icon" alt="Menus">
    </div>
    <div class="content welcomeText">
        <div class="title m-b-md ">
            Application Android
        </div>
        <img src="/asset/baseline-android-24px.svg" class="rounded mx-auto d-block icon" alt="Menus">
    </div>
</div>
{{--</body>--}}
{{--</html>--}}
@endsection