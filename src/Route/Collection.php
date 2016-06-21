<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2016 Nathan Bishop
 */
namespace Meek\Routing\Route;

use IteratorAggregate;
use Meek\Routing\Route;
use RuntimeException;
use ArrayIterator;

/**
 * Used to group together a collection of "routes".
 *
 * @version 0.1.0
 * @author Nathan Bishop (nbish11)
 * @copyright 2016 Nathan Bishop
 * @license MIT
 */
class Collection implements IteratorAggregate
{
    /**
     * The default type of route this collection uses.
     *
     * @var string
     */
    const DEFAULT_ROUTE_TYPE = Route::class;

    /**
     * The collection of "routes".
     *
     * @var array
     */
    private $routes = [];

    /**
     * The type of routes this collection "collects".
     *
     * @var string
     */
    private $type;

    /**
     * Costructs a new route collection.
     *
     * @param array $routes Optional routes to pre-add.
     */
    public function __construct(array $routes = [], $type = self::DEFAULT_ROUTE_TYPE)
    {
        $this->type = $type;

        foreach ($routes as $route) {
            $this->add($route);
        }
    }

    /**
     * Adds a "GET" route to the collection.
     *
     * @see    Collection::map
     * @param  string   $path     The URI path (request target).
     * @param  callable $callback The callback to call when the
     * @return Route The route object added.
     */
    public function get($path, $callback)
    {
        $name = md5(uniqid(rand(), true));

        return $this->map($name, $path, $callback)->addMethod('GET');
    }

    /**
     * Adds a "POST" route to the collection.
     *
     * @see    Collection::map
     * @param  string   $path     The URI path (request target).
     * @param  callable $callback The callback to call when the
     * @return Route The route object added.
     */
    public function post($path, $callback)
    {
        $name = md5(uniqid(rand(), true));

        return $this->map($name, $path, $callback)->addMethod('POST');
    }

    /**
     * Adds a "PATCH" route to the collection.
     *
     * @see    Collection::map
     * @param  string   $path     The URI path (request target).
     * @param  callable $callback The callback to call when the
     * @return Route The route object added.
     */
    public function patch($path, $callback)
    {
        $name = md5(uniqid(rand(), true));

        return $this->map($name, $path, $callback)->addMethod('PATCH');
    }

    /**
     * Adds a "DELETE" route to the collection.
     *
     * @see    Collection::map
     * @param  string   $path     The URI path (request target).
     * @param  callable $callback The callback to call when the
     * @return Route The route object added.
     */
    public function delete($path, $callback)
    {
        $name = md5(uniqid(rand(), true));

        return $this->map($name, $path, $callback)->addMethod('DELETE');
    }

    /**
     * Adds an "OPTIONS" route to the collection.
     *
     * @see    Collection::map
     * @param  string   $path     The URI path (request target).
     * @param  callable $callback The callback to call when the
     * @return Route The route object added.
     */
    public function options($path, $callback)
    {
        $name = md5(uniqid(rand(), true));

        return $this->map($name, $path, $callback)->addMethod('OPTIONS');
    }

    /**
     * Adds a "HEAD" route to the collection.
     *
     * @see    Collection::map
     * @param  string   $path     The URI path (request target).
     * @param  callable $callback The callback to call when the
     * @return Route The route object added.
     */
    public function head($path, $callback)
    {
        $name = md5(uniqid(rand(), true));

        return $this->map($name, $path, $callback)->addMethod('HEAD');
    }

    /**
     * Essentially a wrapper around the {@see Collection::add} method,
     * that lazily instantiates the correct `Route` object.
     *
     * @param  string   $name     The route name (each route name should be unique).
     * @param  string   $path     The URI path this route should respond to.
     * @param  callable $callback The callback to use on a successfull match.
     * @return Route The route object added.
     */
    public function map($name, $path, $callback)
    {
        return $this->add(new $this->type($name, $path, $callback));
    }

    /**
     * Adds a `Route` to the collection.
     *
     * @param  Route $route The route to add.
     * @return Route The route object added.
     */
    public function add(Route $route)
    {
        if ($route instanceof $this->type) {
            $hash = spl_object_hash($route);
            $this->routes[$hash] = $route;

            return $route;
        }

        throw new RuntimeException('This collection instance does not support the route type you provided.');
    }

    /**
     * Removes a `Route` from the collection.
     *
     * @param  Route $route The route to remove.
     * @return Route The route object removed.
     */
    public function remove(Route $route)
    {
        if ($route instanceof $this->type) {
            $hash = spl_object_hash($route);

            if (isset($this->routes[$hash])) {
                unset($this->routes[$hash]);
            }

            return $route;
        }

        throw new RuntimeException('This collection instance does not support the route type you provided.');
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->routes);
    }
}
