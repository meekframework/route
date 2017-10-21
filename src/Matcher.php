<?php declare(strict_types=1);

namespace Meek\Route;

use Psr\Http\Message\ServerRequestInterface;

/**
 *
 *
 * @author Nathan Bishop <nbish11@hotmail.com> (https://nathanbishop.name)
 * @copyright 2016 Nathan Bishop
 * @license The MIT license
 */
class Matcher
{
    /**
     * @var string The regex used to match placeholders in a URI path.
     */
    const PLACEHOLDER_REGEX = '/:([^\/]+)/';

    private $routes;

    public function __construct(Collection $routes)
    {
        $this->routes = $routes;
    }

    public function match(ServerRequestInterface $serverRequest): Route
    {
        $matchedRoutes = $this->matchRequestTarget($serverRequest);
        $matchedRoute = $this->matchRequestMethod($matchedRoutes, $serverRequest);

        return $matchedRoute;
    }

    private function matchRequestTarget($serverRequest): array
    {
        $matchedRoutes = [];
        $requestTarget = $serverRequest->getRequestTarget();

        foreach ($this->routes as $route) {
            $routePath = $route->getPath();

            if ($routePath === $requestTarget) {
                array_push($matchedRoutes, $route);
            } else if (preg_match_all($this->getPattern($routePath), $requestTarget, $matches, PREG_SET_ORDER)) {
                $route->setAttributes($this->extractPlaceholderValues($matches));
                array_push($matchedRoutes, $route);
            }
        }

        if (empty($matchedRoutes)) {
            throw new TargetNotMatched($requestTarget);
        }

        return $matchedRoutes;
    }

    private function matchRequestMethod(array $matchedRoutes, ServerRequestInterface $serverRequest): Route
    {
        $allowedMethods = [];
        $requestMethod = $serverRequest->getMethod();

        foreach ($matchedRoutes as $route) {
            $routeMethod = $route->getMethod();

            // normal method matching
            if (strcasecmp($routeMethod, $requestMethod) === 0) {
                return $route;

            // allow 'GET' routes to respond to 'HEAD' requests
            } else if (strcasecmp($requestMethod, 'head') === 0 && strcasecmp($routeMethod, 'get') === 0) {
                return $route;
            }

            array_push($allowedMethods, $routeMethod);
        }

        throw new MethodNotMatched($requestMethod, $allowedMethods);
    }

    public function getPattern($routePath): string
    {
        $pattern = preg_replace_callback(
            static::PLACEHOLDER_REGEX,
            function ($match) {
                return sprintf('(?<%s>[^/]+)', $match[1]);
            },
            $routePath
        );

        return sprintf('/^%s$/', str_replace('/', '\/', $pattern));
    }

    public function extractPlaceholderValues(array $matches): array
    {
        array_shift($matches[0]); // remove full match

        return array_filter($matches[0], 'is_string', ARRAY_FILTER_USE_KEY);
    }
}
