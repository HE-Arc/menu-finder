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

    public function dishes()
    {
        return $this->hasMany('App\Dish');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
