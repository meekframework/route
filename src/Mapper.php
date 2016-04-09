<?php declare(strict_types=1);

namespace Meek\Route;

/**
 * Maps various HTTP verbs to a route collection.
 *
 * @author Nathan Bishop <nbish11@hotmail.com> (https://nathanbishop.name)
 * @copyright 2016 Nathan Bishop
 * @license The MIT license.
 */
class Mapper
{
    /**
     * @var Collection The collection of 'mapped' routes.
     */
    private $collection;

    /**
     * Creates a new route mapper.
     *
     * @param Collection $collection The collection to store the mapped routes in.
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Adds a route that responds to the 'HEAD' request method to the collection.
     *
     * @param string $path The path/pattern the route should respond to.
     * @param callable $handler The method/function to call when a route is matched.
     * @return Route The actual route object being added to the collection.
     */
    public function head(string $path, callable $handler): Route
    {
        $route = new Route('head', $path, $handler);

        $this->collection->add($route);

        return $route;
    }

    /**
     * Adds a route that responds to the 'GET' request method to the collection.
     *
     * @param string $path The path/pattern the route should respond to.
     * @param callable $handler The method/function to call when a route is matched.
     * @return Route The actual route object being added to the collection.
     */
    public function get(string $path, callable $handler): Route
    {
        $route = new Route('get', $path, $handler);

        $this->collection->add($route);

        return $route;
    }

    /**
     * Adds a route that responds to the 'POST' request method to the collection.
     *
     * @param string $path The path/pattern the route should respond to.
     * @param callable $handler The method/function to call when a route is matched.
     * @return Route The actual route object being added to the collection.
     */
    public function post(string $path, callable $handler): Route
    {
        $route = new Route('post', $path, $handler);

        $this->collection->add($route);

        return $route;
    }

    /**
     * Adds a route that responds to the 'PUT' request method to the collection.
     *
     * @param string $path The path/pattern the route should respond to.
     * @param callable $handler The method/function to call when a route is matched.
     * @return Route The actual route object being added to the collection.
     */
    public function put(string $path, callable $handler): Route
    {
        $route = new Route('put', $path, $handler);

        $this->collection->add($route);

        return $route;
    }

    /**
     * Adds a route that responds to the 'PATCH' request method to the collection.
     *
     * @param string $path The path/pattern the route should respond to.
     * @param callable $handler The method/function to call when a route is matched.
     * @return Route The actual route object being added to the collection.
     */
    public function patch(string $path, callable $handler): Route
    {
        $route = new Route('patch', $path, $handler);

        $this->collection->add($route);

        return $route;
    }

    /**
     * Adds a route that responds to the 'DELETE' request method to the collection.
     *
     * @param string $path The path/pattern the route should respond to.
     * @param callable $handler The method/function to call when a route is matched.
     * @return Route The actual route object being added to the collection.
     */
    public function delete(string $path, callable $handler): Route
    {
        $route = new Route('delete', $path, $handler);

        $this->collection->add($route);

        return $route;
    }

    /**
     * Adds a route that responds to the 'OPTIONS' request method to the collection.
     *
     * @param string $path The path/pattern the route should respond to.
     * @param callable $handler The method/function to call when a route is matched.
     * @return Route The actual route object being added to the collection.
     */
    public function options(string $path, callable $handler): Route
    {
        $route = new Route('options', $path, $handler);

        $this->collection->add($route);

        return $route;
    }

    /**
     * Retrieve the route collection used by the mapper.
     *
     * @return Collection The same collection passed in to the Mapper construct.
     */
    public function getCollection(): Collection
    {
        return $this->collection;
    }
}
