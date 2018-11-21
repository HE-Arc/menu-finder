<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'restaurant_id',
        'category_id',
        'price',
        'start',
        'end',
        'active',
    ];

    public function getStartFormatAttribute() {
        return \Carbon\Carbon::parse($this->attributes['start'])->format('d-m-Y');
    }
    public function getEndFormatAttribute() {
        return \Carbon\Carbon::parse($this->attributes['end'])->format('d-m-Y');
    }

    public function dishes()
    {
        return $this->hasMany('App\Dish');
    }
    public function getAllDishesAttribute()
    {
        return $this->dishes()->get()->groupBy('type');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function  getMainDishesAttribute()
    {
        return $this->dishes()->where('type', 'main','==')->get();
    }
    public function  getStarterDishesAttribute()
    {
        return $this->dishes()->where('type', 'starter','==')->get();
    }
    public function  getDessertDishesAttribute()
    {
        return $this->dishes()->where('type', 'dessert','==')->get();
    }

}
