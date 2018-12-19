<?php

namespace App;

use Carbon\Carbon;
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

    public function getStartFormatAttribute()
    {
        return Carbon::parse($this->attributes['start'])->format('d-m-Y');
    }
    public function getEndFormatAttribute()
    {
        return Carbon::parse($this->attributes['end'])->format('d-m-Y');
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

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function getPriceAttribute($value)
    {
        return round((float) $value, 2);
    }

    /**
     * Returns all menus active today within a given radius.
     * @param $lat
     * @param $lng
     * @param $radius
     * @return mixed
     */
    public static function allWithinRadius($lat, $lng, $radius)
    {
        // @todo Check if it's possible to use the same SQL query used in Restaurant model (currently not DRY =/)
        $menus = Menu::whereHas('restaurant', function ($query) use ($lat, $lng, $radius) {
            // Named parameters can't be used because of the additional where clauses below
            $sql = 'ST_DWithin(location, ST_Point(?, ?)::geography, ?)';
            $query->whereRaw($sql, [
                $lng,
                $lat,
                $radius * 1000,
            ]);
        });

        $menus->where('active', true);
        $menus->where('start', '<=', Carbon::today()->toDateString());
        $menus->where('end', '>=', Carbon::today()->toDateString());

        return $menus->get();
    }

    public function getMainDishesAttribute()
    {
        return $this->dishes()->where('type', 'main', '==')->get();
    }

    public function getStarterDishesAttribute()
    {
        return $this->dishes()->where('type', 'starter', '==')->get();
    }

    public function getDessertDishesAttribute()
    {
        return $this->dishes()->where('type', 'dessert', '==')->get();
    }
}
