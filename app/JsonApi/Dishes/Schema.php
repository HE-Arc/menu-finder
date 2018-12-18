<?php

namespace App\JsonApi\Dishes;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'dishes';

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
     * @inheritdoc
     */
    public function getResourceLinks($resource)
    {
        // Don't show any resource link since dishes endpoint is currently not implemented
        return [];
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
            'dish-type' => $resource->type,
        ];
    }
}
