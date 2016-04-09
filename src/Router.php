<?php

namespace Meek\Routing;

use Meek\Routing\RouteCollection;
use Meek\Routing\Route;
use Meek\Routing\Exceptions\NotFound as NotFoundException;
use Meek\Routing\Exceptions\MethodNotAllowed as MethodNotAllowedException;

/**
 *
 */
class Router
{
    /**
     * [$routes description]
     * @var RouteCollection
     */
    private $routes;

    /**
     * [__construct description]
     * @param RouteCollection $routes [description]
     */
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * [dispatch description]
     * @param  string $requestMethod [description]
     * @param  string $requestUri    [description]
     * @return [type]                [description]
     */
    public function dispatch($requestMethod, $requestUri)
    {
        $matchedRoutes = [];
        $params = [];
        $methodMatched = false;

        // first, lets find some routes to match against
        foreach ($this->routes as $route) {
            if (preg_match($route->getPattern(), $requestUri, $params)) {
				array_shift($params); // remove full match
                array_values($params);  // get param values

                $matchedRoutes[] = $route;
			}
        }

        // no routes? throw exception and let user handle
        if (empty($matchedRoutes)) {
            throw new NotFoundException();
        }

        // we have matched routes, now time to match methods
        foreach ($matchedRoutes as $matchedRoute) {
            $routeMethod = $matchedRoute->getMethod();

            if ($requestMethod === $routeMethod ||
                $requestMethod === 'HEAD' && ($routeMethod === 'HEAD' || $routeMethod === 'GET')) {
                $methodMatched = true;
                $response = call_user_func_array($matchedRoute->getCallback(), $params);

                // A response body should not be sent when responding to a HEAD request
                if ($requestMethod !== 'HEAD') {
                    echo $response;
                }

                break;
            }
        }

        if (!$methodMatched) {
            throw new MethodNotAllowedException();
        }

        return $this;
    }
}
