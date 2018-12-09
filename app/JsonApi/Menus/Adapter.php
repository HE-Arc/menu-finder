<?php

namespace App\JsonApi\Menus;

use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Eloquent\BelongsTo;
use CloudCreativity\LaravelJsonApi\Eloquent\HasMany;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Adapter extends AbstractAdapter
{

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new \App\Menu(), $paging);
    }

    /**
     * @param Builder $query
     * @param Collection $filters
     * @return void
     */
    protected function filter($query, Collection $filters)
    {
        // TODO
    }

    /**
     * @return BelongsTo
     */
    protected function restaurant()
    {
        return $this->belongsTo();
    }

    /**
     * @return HasMany
     */
    protected function categories()
    {
        return $this->hasMany();
    }

    /**
     * @return HasMany
     */
    protected function dishes()
    {
        return $this->hasMany();
    }
}
