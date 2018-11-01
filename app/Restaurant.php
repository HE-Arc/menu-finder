<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

class Restaurant extends Model
{
    use PostgisTrait;


    protected $fillable = [
    'name',
    'user_id',
    'active',
    'rate_sum',
    'rate_nb',
    'location',
    'address',
    'zip',
    'city',
    'avatar',
    'description',
    ];

    protected $postgisFields = [
    'location',
    ];

  /**
  * Retrieves all restaurants located within the given radius of a given point.
  * @param double $lat The latitude of the center point.
  * @param double $lng The longitude of the center point.
  * @param double $radius The radius in km.
  * @return Collection
  * @link https://postgis.net/docs/ST_DWithin.html PostGIS' ST_DWithin documentation.
  */
    public static function allWithinRadius($lat, $lng, $radius)
    {
        $query = 'ST_DWithin(position, ST_Point(:lng, :lat)::geography, :radius)';
        return Restaurant::whereRaw($query, [
        'lng' => $lng,
        'lat' => $lat,
        'radius' => $radius * 1000,
        ])->get();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function menus()
    {
        return $this->hasMany('App\Menu');
    }
}
