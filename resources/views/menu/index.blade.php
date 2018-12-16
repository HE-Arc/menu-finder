@extends('layouts.app')
@section('content')
<h1>Menu View  @if(isset($menus))<a class="right-Link btn btn-primary" href="{{action('MenuController@create')}}"> Add a menu</a>@endif </h1>
<div class="menu-index">
    @if(session('succesMessage'))
        <div class="alert alert-success">
            {{session('succesMessage')}}
        </div>
    @endif
    <div id="accordion">
        @if($menus != null)
            @forelse($menus as $key => $menu)
                <div class="card">
                    <div class="card-header" id="{{'heading'.$loop->index}}" data-toggle="collapse" data-target="{{'#collapse'.$loop->index}}" aria-expanded="true" aria-controls="{{'collapse'.$loop->index}}">
                        <h5 class="{{'head-'.$loop->index}}">
                            <span>{{$menu->name}}</span>  <span class="span-date">{{$menu->start_format . " / " . $menu->end_format}}</span>
                        </h5>
                    </div>

                    <div id="{{'collapse'.$loop->index}}" class="collapse hide" aria-labelledby="{{'heading'.$loop->index}}" data-parent="#accordion">
                        <div class="card-body">
                            <h5>Categories : @forelse($menu->categories as $key => $category) {{$category->name .", "}}@empty no category @endforelse</h5>
                            @php($menusByType  = $menu->all_dishes)
                            @if(isset($menusByType['starter']))
                                <h5>Starter(s)</h5>
                                <ul class="list-group">
                                    @foreach($menusByType['starter'] as $key => $starterDish)
                                        <li class="list-group-item">{{$starterDish->name}}</li>
                                    @endforeach
                                </ul>
                            @endif
                            @if(isset($menusByType['main']))
                                <h5>Main(s)</h5>
                                <ul class="list-group">
                                    @foreach($menusByType['main'] as $key => $mainDish)
                                        <li class="list-group-item">{{$mainDish->name}}</li>
                                    @endforeach
                                </ul>
                            @endif
                            @if(isset($menusByType['dessert']))
                                <h5>Dessert(s)</h5>
                                <ul class="list-group">
                                    @foreach($menusByType['dessert'] as $key => $dessertDish)
                                        <li class="list-group-item">{{$dessertDish->name}}</li>
                                    @endforeach
                                </ul>
                                @endif
                                <br>
                            <h5 style="display: inline-block">Price : {{$menu->price}} chf</h5>

                            <a href="{{route('menus.edit', ['id'=>$menu->id])}}" class="right-Link btn btn-primary">Edit</a>
                            {!! Form::open(['method' => 'DELETE','route' => ['menus.destroy', $menu->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger right-Link']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning">
                    <h3>You haven't registered menu yet</h3> <a class="right-Link btn btn-primary" href="{{action('MenuController@create')}}"> Add a menu</a>
                </div>
            @endforelse
            @else
            <div class="alert alert-warning">
                <h3>You haven't registered a restaurant yet</h3> <a class="right-Link btn btn-primary" href="{{action('RestaurantController@index')}}"> Add a Restaurant</a>
            </div>
            @endif
    </div>
</div>
@endsection