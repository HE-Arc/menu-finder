@extends('layouts.fluid')

@section('content')
<div class="parallax"></div>
<div class="flex-center position-ref">
    <div class="content welcomeText">
        <div class="title m-b-md">
            Restaurants
            <h2>Register and add your restaurant</h2>
        </div>

        <img src="/asset/sharp-restaurant-24px.svg" class="rounded mx-auto d-block icon" alt="Restaurant">
    </div>
    <div class="content welcomeText">
        <div class="title m-b-md ">
            Menus
            <h2> Add some daily menus </h2>
        </div>
        <img src="/asset/sharp-restaurant_menu-24px.svg" class="rounded mx-auto d-block icon" alt="Menus">
    </div>
    <div class="content welcomeText">
        <div class="title m-b-md ">
            Android Application
            <h2>Now everybody can see your menu with the Android app </h2>
            <h2> Just wait for the customers to come </h2>
        </div>
        <img src="/asset/baseline-android-24px.svg" class="rounded mx-auto d-block icon" alt="Menus">
    </div>
    <div class="content welcomeText">
        <div class="title m-b-md ">
            <button class="startBtn"><a href="restaurants" class="linkStart">Get started now!</a></button>
        </div>
    </div>
</div>
@endsection
