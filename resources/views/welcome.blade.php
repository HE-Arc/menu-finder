@extends('layouts.fluid')

@section('content')
<div class="parallax"></div>
<div class="flex-center position-ref">
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
@endsection