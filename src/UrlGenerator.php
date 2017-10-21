<?php declare(strict_types=1);

namespace Meek\Route;

use RuntimeException;

/**
 * Generates a URL from a route's request target.
 *
 * @author Nathan Bishop <nbish11@hotmail.com> (https://nathanbishop.name)
 * @copyright 2016 Nathan Bishop
 * @license The MIT license.
 */
class UrlGenerator
{
    /**
     * @var Collection The route collection.
     */
    private $routes;

    /**
     * Constructs a new route path generator.
     *
     * @param Collection $routes The collection of "named" routes.
     */
    public function __construct(Collection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Generates a URL for the given route name.
     *
     * @param string $name The route name.
     * @param array $context Replacements for named placeholders.
     * @throws RuntimeException [<description>]
     * @return string [description]
     */
    public function generate(string $name, array $context = [])
    {
        foreach ($this->routes as $route) {
            if ($route->getName() === $name) {
                return static::interpolate($route->getPath(), $context);
            }
        }

        throw new RuntimeException(sprintf('The route for "%s" does not exist.', $name));
    }

    /**
     * Replaces placeholders in a template with their contextual values.
     *
     * @param string $template [description]
     * @param array $context [description]
     * @return string [description]
     */
    protected static function interpolate($template, array $context = [])
    {
        $replacements = [];

        foreach ($context as $key => $value) {
            $replacements[":{$key}"] = $value;
        }

        return strtr($template, $replacements);
    }
}
