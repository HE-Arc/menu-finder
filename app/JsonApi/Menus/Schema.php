<?php

namespace App\JsonApi\Menus;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'menus';

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
            'price' => $resource->price,
            'start' => $resource->start->toIso8601String(),
            'end' => $resource->end->toIso8601String(),
            'active' => $resource->active,
        ];
    }
}
