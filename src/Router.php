<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2016 Nathan Bishop
 */
namespace Meek\Routing;

use Meek\Routing\Route\Collection;
use Meek\Routing\Route\Matcher;
use Meek\Routing\Route\Dispatcher;
use Meek\Routing\Path\Generator;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Matches incoming requests, and routes, to the appropriate dispatcher.
 *
 * The router class essentially acts as a proxy for the following classes:
 *     `Meek\Routing\Route\Collection`
 *     `Meek\Routing\Route\Matcher`
 *     `Meek\Routing\Route\Dispatcher`
 *     `Meek\Routing\Path\Generator`
 *
 * @version 0.1.0
 * @author Nathan Bishop (nbish11)
 * @copyright 2016 Nathan Bishop
 * @license MIT
 */
class Router
{
    /**
     * The route collection.
     *
     * @var Collection
     */
    private $routes;

    /**
     * The route matcher.
     *
     * @var Matcher
     */
    private $matcher;

    /**
     * The rout dispatcher.
     *
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * The path generator for named routes.
     *
     * @var Generator
     */
    private $generator;

    /**
     * Constructs a new `Router` instance.
     *
     * @param Collection $routes     The route collection.
     * @param Matcher    $matcher    The route matcher.
     * @param Dispatcher $dispatcher The route dispatcher.
     * @param Generator  $generator  The path generator for named routes.
     */
    public function __construct(
        Collection $routes,
        Matcher $matcher,
        Dispatcher $dispatcher,
        Generator $generator
    ) {
        $this->routes = $routes;
        $this->matcher = $matcher;
        $this->dispatcher = $dispatcher;
        $this->generator = $generator;
    }

    /**
     * Retrieves the route collection object.
     *
     * @return Collection
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Retrieves the route matcher object.
     *
     * @return Matcher
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * Retrieves the route dispatcher object.
     *
     * @return Dispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * Retrieves the route path generator object.
     *
     * @return Generator
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * Alias for the {@see Matcher::match} method.
     */
    public function match(ServerRequestInterface $request)
    {
        return $this->getMatcher()->match($request);
    }

    /**
     * Alias for the {@see Dispatcher::dispatch} method.
     */
    public function dispatch(ServerRequestInterface $request)
    {
        return $this->getDispatcher()->dispatch($request);
    }

    /**
     * Alias for the {@see Generator::generate} method.
     */
    public function generate($name, array $parameters)
    {
        return $this->getGenerator()->generate($name, $parameters);
    }

    /**
     * Allows the `Router` object to act as a proxy for the route collection.
     *
     * @param  string $method    The method to call on the route collection.
     * @param  array  $arguments The arguments to forward to the method to call.
     * @return mixed While the return value can be anything, in general,
     *               it usually returns an instance of `Meek\Routing\Route`.
     */
    public function __call($method, array $arguments = [])
    {
        return call_user_func_array([$this->routes, $method], $arguments);
    }

    /**
     * Factory method for creating empty `Router` instances with
     * the required dependecies pre-resolved.
     *
     * @return static
     */
    public static function create()
    {
        $routes = new Collection();
        $matcher = new Matcher($routes);
        $dispatcher = new Dispatcher($matcher);
        $generator = new Generator($routes);

        return new static($routes, $matcher, $dispatcher, $generator);
    }
}
