<?php declare(strict_types=1);

namespace Meek\Route;

use InvalidArgumentException;

/**
 * Models a 'route' object.
 *
 * @author Nathan Bishop <nbish11@hotmail.com> (https://nathanbishop.name)
 * @copyright 2016 Nathan Bishop
 * @license The MIT license.
 */
class Route
{
    /**
     * @var string The name of the route.
     */
    private $name;

    /**
     * @see https://tools.ietf.org/html/rfc7231#section-4
     * @var string The request method the route should match.
     */
    private $method;

    /**
     * @see https://tools.ietf.org/html/rfc7230#section-5.3
     * @var string The request target the route should match.
     */
    private $path;

    /**
     * @var callable The handler to be called on route match.
     */
    private $handler;

    /**
     * @var string[] Additional attributes to attach to the route. Usually the parsed placeholders from the request.
     */
    private $attributes;

    /**
     * Creates a new route object.
     *
     * @param string $method The request method as defined in RFC7231, Section 4.
     * @param string $path The request target as defined in RFC7230, Section 5.3.
     * @param callable $handler The callback to be called on a successful match.
     */
    public function __construct(string $method, string $path, callable $handler)
    {
        $this->method = strtoupper($method);

        if ($path !== '*' && (substr($path, 0, 1) !== '/')) {
            throw new InvalidArgumentException('Path must either be an asterix ("*") or begin with a slash("/")');
        }

        $this->path = $path;
        $this->handler = $handler;
        $this->name = '';
        $this->attributes = [];
    }

    /**
     * Retrieve the method the route responds to.
     *
     * @return string The request method.
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Retrieve the path the route responds to.
     *
     * @return string An empty string if there is no path.
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Retrieves the callback.
     *
     * @return callable The callback for the route.
     */
    public function getHandler(): callable
    {
        return $this->handler;
    }

    /**
     * Set the name of the route.
     *
     * @param string $name The name to assign the route
     * @throws InvalidArgumentException [<description>]
     */
    public function setName(string $name): void
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Route name cannot be empty');
        }

        $this->name = $name;
    }

    /**
     * Retrieve the route name.
     *
     * @return string An empty string if the route has no name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set some additional route data on the route.
     *
     * @param string[] $attributes Additional data to add to the route.
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * Retrieve the route data.
     *
     * @return string[] Additional data for the route.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
