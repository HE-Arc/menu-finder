<?php

namespace App\JsonApi\Menus;

use App\Menu;
use App\Restaurant;
use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'menus';

    /**
     * @var array
     */
    protected $relationships = [
        'restaurant',
        'categories',
        'dishes',
    ];

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

    /**
     * @param Menu $resource
     * @param bool $isPrimary
     * @param array $includedRelationships
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includedRelationships)
    {
        return [
            'restaurant' => [
                self::SHOW_SELF => false,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => true,
                self::DATA => function () use ($resource) {
                    return $resource->restaurant;
                },
            ],
            'categories' => [
                self::SHOW_SELF => false,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => true,
                self::DATA => function () use ($resource) {
                    return $resource->categories;
                },
            ],
            'dishes' => [
                self::SHOW_SELF => false,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => true,
                self::DATA => function () use ($resource) {
                    return $resource->dishes;
                },
            ],
        ];
    }
}
