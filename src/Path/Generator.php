<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2016 Nathan Bishop
 */
namespace Meek\Routing\Path;

use Meek\Routing\Route\Collection;
use Meek\Routing\Route;
use RuntimeException;

/**
 * Generates a URI "path" from a named route.
 *
 * @version 0.1.0
 * @author Nathan Bishop (nbish11)
 * @copyright 2016 Nathan Bishop
 * @license MIT
 */
class Generator
{
    /**
     * The route collection.
     *
     * @var Collection
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
     * Generates a new URI "path" to be used in HTML markup.
     *
     * @param  string $name    The route name.
     * @param  array  $context Replacements for named placeholders.
     * @return string
     */
    public function generate($name, array $context = [])
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
     * @param  string $template [description]
     * @param  array  $context  [description]
     * @return string
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
