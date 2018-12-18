<?php

namespace App\JsonApi\Menus;

use Carbon\Carbon;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Eloquent\BelongsTo;
use CloudCreativity\LaravelJsonApi\Eloquent\HasMany;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Neomerx\JsonApi\Contracts\Encoder\Parameters\EncodingParametersInterface;

class Adapter extends AbstractAdapter
{

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Whitelist of custom filters.
     * @var array
     */
    protected $allowed_custom_filter = [
        'lat',
        'lng',
        'radius',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        /**
         * Unfortunately, we did not have time to manage pagination, but it should be easy to implement it
         * using laraval-json-api package
         * @link https://laravel-json-api.readthedocs.io/en/latest/fetching/pagination/
         */
        parent::__construct(new \App\Menu(), $paging);
    }

    /**
     * Whitelist the custom attributes used for filtering
     * @param array $to_whitelist
     * @return array
     */
    protected function whitelistAllowedCustomFilter($to_whitelist)
    {
        return array_filter($to_whitelist, function ($key) {
            return in_array($key, $this->allowed_custom_filter);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @param Builder $query
     * @param Collection $filters
     * @return void
     */
    protected function filter($query, Collection $filters)
    {
        /**
         * By default, we only return menus that are available today.
         * @todo Add a query parameter to allow the user to query for other day's menus.
         */
        $query->where('active', true);
        $query->where('start', '<=', Carbon::today()->toDateString());
        $query->where('end', '>=', Carbon::today()->toDateString());

        /**
         * Filters by categories (many-to-many relationship).
         */
        if ($categories = $filters->get('categories')) {
            $query->whereHas('categories', function ($relation_query) use ($categories) {
                $relation_query->whereIn('category_id', $categories);
            });
        }

        /**
         * We can only check for the presence of one geospatial query attribute,
         * it is up to the validator to make sure that the others are given by the user
         * @see Validators::queryRules
         *
         * @todo Check if it's somehow possible to use the same SQL query everywhere to avoid WET code.
         * @see \App\Restaurant::allWithinRadius()
         * @see \App\Menu::allWithinRadius()
         */
        if ($filters->has('radius')) {
            $query->whereHas('restaurant', function ($relation_query) use ($filters) {
                $sql = 'ST_DWithin(location, ST_Point(?, ?)::geography, ?)';
                $relation_query->whereRaw($sql, [
                    $filters->get('lng'),
                    $filters->get('lat'),
                    floatval($filters->get('radius')) * 1000,
                ]);
            });
        }
    }

    /**
     * Override base class method to add custom query without using json-api "filter." query parameters.
     * From what we understood, it is better to use custom query parameters when filtering according to an
     * attribute which doesn't belongs to the model.
     *
     * @inheritdoc
     */
    protected function queryAll($query, EncodingParametersInterface $parameters)
    {
        /** Apply eager loading */
        $this->with($query, $parameters);

        /** Filter */
        $filters = collect($parameters->getFilteringParameters());
        /** Workaround to add our custom query parameters as filters (only whitelîsted custom parameters will pass */
        if (is_array($parameters->getUnrecognizedParameters())) {
            $filters = $filters->merge($this->whitelistAllowedCustomFilter($parameters->getUnrecognizedParameters()));
        }
        $this->applyFilters($query, $filters);

        /** Sort */
        $this->sort($query, $parameters->getSortParameters());

        /** Paginate results if needed. */
        $pagination = collect($parameters->getPaginationParameters());

        return $pagination->isEmpty() ? $this->all($query) : $this->paginate($query, $parameters);
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
