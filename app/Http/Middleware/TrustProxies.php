<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;

    /**
     * Trusted proxies setup to avoid mixed content error on the production server.
     *
     * @param Repository $config
     *
     * @link https://github.com/HE-Arc/menu-finder/issues/14
     * @link https://laravel.com/docs/5.7/requests#configuring-trusted-proxies
     * @link https://github.com/fideloper/TrustedProxy#why-does-this-matter
     */
    public function __construct(Repository $config)
    {
        parent::__construct($config);

        $proxies = env('X_FORWARDED_TRUSTED_PROXIES');
        if (!empty($proxies)) {
            $this->proxies = explode(',', $proxies);
        }
    }
}
