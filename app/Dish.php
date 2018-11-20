<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'menu_id',
    ];

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }
}
