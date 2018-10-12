<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

/**
 * This class is intended to be an example of how to use
 * PostGis "radius" request.
 * It should be deleted once the Restaurant model is created.
 *
 * Check its migration file.
 * @package App
 */
class Location extends Model
{
    use PostgisTrait;

    protected $fillable = [
        'name',
        'position',
    ];

    protected $postgisFields = [
        'position',
    ];

    /**
   * Retrieves all locations located within the given radius of a given point.
   * @param double $lat The latitude of the center point.
   * @param double $lng The longitude of the center point.
   * @param double $radius The radius in km.
   * @return Collection
   * @link https://postgis.net/docs/ST_DWithin.html PostGIS' ST_DWithin documentation.
   */
    public static function allWithinRadius($lat, $lng, $radius)
    {
        $query = 'ST_DWithin(position, ST_Point(:lng, :lat)::geography, :radius)';

        return Location::whereRaw($query, [
            'lng' => $lng,
            'lat' => $lat,
            'radius' => $radius * 1000,
        ])->get();
    }
}
