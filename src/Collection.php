<?php declare(strict_types=1);

namespace Meek\Route;

use IteratorAggregate;
use Countable;
use ArrayIterator;
use LogicException;

/**
 * Stores route objects.
 *
 * @author Nathan Bishop <nbish11@hotmail.com> (https://nathanbishop.name)
 * @copyright 2016 Nathan Bishop
 * @license The MIT license
 */
class Collection implements IteratorAggregate, Countable
{
    /**
     * @var Route[] Store for the route objects.
     */
    private $routes = [];

    /**
     * Creates a new collection.
     */
    public function __construct(array $routes = [])
    {
        foreach ($routes as $route) {
            $this->add($route);
        }
    }

    /**
     * Add a route object to the collection.
     *
     * @param Route $route The route to add.
     */
    public function add(Route $route): void
    {
        $hash = spl_object_hash($route);

        $this->routes[$hash] = $route;
    }

    /**
     * Remove a route object from the collection.
     *
     * @param Route $route The route to remove.
     * @throws LogicException When trying to remove a route not in the collection.
     */
    public function remove(Route $route): void
    {
        $hash = spl_object_hash($route);

        if (!array_key_exists($hash, $this->routes)) {
            throw new LogicException('Cannot remove non-existent route');
        }

        unset($this->routes[$hash]);
    }

    /**
     * Check if a route object is in the collection.
     *
     * @param Route $route The route object to check for.
     * @return boolean True, if the route exists in the collection.
     */
    public function contains(Route $route): bool
    {
        $hash = spl_object_hash($route);

        return array_key_exists($hash, $this->routes);
    }

    /**
     * Count the route objects in the collection.
     *
     * @return integer The number of routes in the collection.
     */
    public function count(): int
    {
        return count($this->routes);
    }

    /**
     * Retrieve an iterator for this collection.
     *
     * @return ArrayIterator An iterator for the routes currently in collection.
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->routes);
    }
}
