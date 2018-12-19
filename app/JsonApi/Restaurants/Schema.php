<?php

namespace App\JsonApi\Restaurants;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'restaurants';

    /**
     * @param $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name' => $resource->name,
            'active' => $resource->active,
            'rate' => $resource->rate,
            'location' => [
                'lat' => $resource->lat,
                'lng' => $resource->lng,
            ],
            'address' => $resource->address,
            'zip' => $resource->zip,
            'city' => $resource->city,
            'avatar' => $resource->avatar_url,
            'website' => $resource->website,
            'description' => $resource->description,
        ];
    }
}
