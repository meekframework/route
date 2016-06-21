<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2016 Nathan Bishop
 */
namespace Meek\Routing\Rule;

use Psr\Http\Message\ServerRequestInterface;
use Meek\Routing\Route;

/**
 * A rule for matching routes against the request method.
 *
 * @version 0.1.0
 * @author Nathan Bishop (nbish11)
 * @copyright 2016 Nathan Bishop
 * @license MIT
 */
class MatchMethod
{
    /**
     * Checks if the incoming request method matches against the
     * allowed methods in the `Route` object.
     *
     * @param  ServerRequestInterface $request The incoming request.
     * @param  Route                  $route   The Route to match against.
     * @return boolean `true` if method matched, `false` otherwise.
     */
    public function __invoke(ServerRequestInterface $request, Route $route)
    {
        return in_array($request->getMethod(), $route->getMethods());
    }
}
