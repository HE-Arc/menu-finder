<?php

namespace App\JsonApi\Menus;

use CloudCreativity\LaravelJsonApi\Validation\AbstractValidators;

class Validators extends AbstractValidators
{

    /**
     * The include paths a client is allowed to request.
     *
     * @var string[]
     */
    protected $allowedIncludePaths = [
        'restaurant',
        'categories',
        'dishes',
    ];

    /**
     * The allowed filtering parameters.
     **
     * @var string[]
     */
    protected $allowedFilteringParameters = [
        'categories',
    ];

    /**
     * Get resource validation rules.
     *
     * @param mixed|null $record
     *      the record being updated, or null if creating a resource.
     * @return mixed
     */
    protected function rules($record = null): array
    {
        return [
            //
        ];
    }

    /**
     * Get query parameter validation rules.
     *
     * @return array
     */
    protected function queryRules(): array
    {
        return [
            'lat' => 'numeric|required_with:lng,radius',
            'lng' => 'numeric|required_with:lat,radius',
            'radius' => 'numeric|required_with:lat,lng',
            'filter.categories' => 'array|min:1',
        ];
    }
}
