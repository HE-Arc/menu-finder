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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start',
        'end',
    ];

    public function dishes()
    {
        return $this->hasMany('App\Dish');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function getPriceAttribute($value)
    {
        return round((float) $value, 2);
    }
}
