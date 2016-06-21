<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2016 Nathan Bishop
 */
namespace Meek\Routing;

use InvalidArgumentException;

/**
 * Models a "route" object.
 *
 * @version 0.1.0
 * @author Nathan Bishop (nbish11)
 * @copyright 2016 Nathan Bishop
 * @license MIT
 */
class Route
{
    /**
     * The regex used to match placeholders in a URI path.
     *
     * By default uses RoR-type placeholders (E.g. ":id", ":action").
     *
     * @var string
     */
    const PLACEHOLDER_REGEX = '/:([^\/]+)/';

    /**
     * The route's name.
     *
     * @var string
     */
    private $name;

    /**
     * The methods this route can respond to.
     *
     * @var string[]
     */
    private $methods;

    /**
     * The URI path this route responds to.
     *
     * @var string
     */
    private $path;

    /**
     * The regex pattern to use for matching this route.
     *
     * @var string
     */
    private $pattern;

    /**
     * The callback to be used when the route is matched.
     *
     * @var callable
     */
    private $callback;

    /**
     * The placeholders in the URI path as well as any custom defined attributes.
     *
     * @var mixed[]
     */
    private $attributes;

    /**
     * Additional rules for the this route to match against (E.g "Rule\MatchMethod").
     *
     * @var callable[]
     */
    private $rules;

    /**
     * Methods the route supports.
     *
     * @var array
     */
    protected static $allowedMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'];

    /**
     * Constructs a new route object.
     *
     * @param string   $name     The route name (each route name should be unique).
     * @param string   $path     The URI path this route should respond to.
     * @param callable $callback The callback to use on a successfull match.
     */
    public function __construct($name, $path, callable $callback)
    {
        $this->name = $name;
        $this->path = $path;
        $this->callback = $callback;
        $this->methods = [];
        $this->attributes = [];
        $this->rules = [];

        $pattern = preg_replace_callback(
            static::PLACEHOLDER_REGEX,
            function ($match) {
                $this->addAttribute($match[1]);
                return sprintf('(?<%s>[^/]+)', $match[1]);
            },
            $this->path
        );

        $this->pattern = sprintf('/^%s$/', str_replace('/', '\/', $pattern));
    }

    /**
     * Retrieves the route name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Retrieves the URI path the route responds to.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * The regex pattern, if using a RegexMatcher.
     *
     * Also adds placeholders found in the URI path to the route {@see Route::$attributes}.
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Retrieves the callback.
     *
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Attaches an additional method to the route.
     *
     * @param string $method A valid HTTP method.
     * @return static
     */
    public function addMethod($method)
    {
        $method = strtoupper($method);

        if (!in_array($method, static::$allowedMethods, true)) {
            throw new InvalidArgumentException('A valid HTTP method was not provided.');
        }

        // HTTP "GET" requests MUST support HTTP "HEAD" requests as well.
        if ($method === 'GET' && !in_array($method, $this->methods)) {
            $this->methods[] = 'HEAD';
        }

        $this->methods[] = $method;

        return $this;
    }

    /**
     * Attaches multiple methods to the route.
     *
     * @see    Route::addMethod
     * @param  string[] $methods The HTTP methods to add.
     * @return static
     */
    public function addMethods(array $methods)
    {
        foreach ($methods as $method) {
            $this->addMethod($method);
        }

        return $this;
    }

    /**
     * Retrieves methods supported by this route.
     *
     * @return string[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Attaches an attribute to the route.
     *
     * @param  string $name  The name of the attribute.
     * @param  mixed  $value The value of the attribute.
     * @return static
     */
    public function addAttribute($name, $value = null)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Attaches multiple attributes to the route.
     *
     * @see    Route::addAttribute
     * @param  mixed[] $attributes The attributes to add.
     * @return static
     */
    public function addAttributes(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->addAttribute($name, $value);
        }

        return $this;
    }

    /**
     * Retrieves the attributes associated with the route.
     *
     * @return mixed[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Attaches an additional matching rule to the route.
     *
     * @param  callable $rule The additional route rule.
     * @return static
     */
    public function addRule(callable $rule)
    {
        $this->rules[] = $rule;

        return $this;
    }

    /**
     * Attaches multiple rules to the route.
     *
     * @see    Route::addRule
     * @param  callable[] $rules The rules to add.
     * @return static
     */
    public function addRules(array $rules)
    {
        foreach ($rules as $rule) {
            $this->addRule($rule);
        }

        return $this;
    }

    /**
     * Retrieves the rules associated with the route.
     *
     * @return callable[]
     */
    public function getRules()
    {
        return $this->rules;
    }
}
