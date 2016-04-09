<?php

namespace Meek\Routing;

use SplObjectStorage;

/**
 *
 */
class RouteCollection extends SplObjectStorage
{
    /**
     * [add description]
     * @param string $method   [description]
     * @param string $path     [description]
     * @param string $callback [description]
     */
    public function add($method, $path, $callback)
    {
        $route = new Route($method, $path, $callback);

        parent::attach($route);

        return $route;
    }
}
