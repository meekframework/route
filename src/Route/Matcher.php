<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2016 Nathan Bishop
 */
namespace Meek\Routing\Route;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Matches a collection of routes against the current request.
 *
 * @version 0.1.0
 * @author Nathan Bishop (nbish11)
 * @copyright 2016 Nathan Bishop
 * @license MIT
 */
class Matcher
{
    /**
     * The route collection.
     *
     * @var Collection
     */
    private $routes;

    /**
     * Constructs a new route matcher.
     *
     * @param null|Collection $routes A collection of routes to match against.
     */
    public function __construct(Collection $routes = null)
    {
        $this->routes = $routes;
    }

    /**
     * Checks to see if any routes can be matched against the current request.
     *
     * @param  ServerRequestInterface $request The current request.
     * @return Route|null
     */
    public function match(ServerRequestInterface $request)
    {
        $path = $request->getUri()->getPath();

        foreach ($this->routes as $route) {
            if (preg_match_all($route->getPattern(), $path, $matches, PREG_SET_ORDER)) {
                array_shift($matches[0]); // remove full match
                $filtered = array_filter($matches[0], 'is_string', ARRAY_FILTER_USE_KEY);
                $route->addAttributes($filtered);

                return $route;
            }
        }

        return null;
    }
}
