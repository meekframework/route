<?php

namespace Meek\Routing;

use InvalidArgumentException;

/**
 *
 */
class Route
{
    /**
     *
     */
    const NAMED_PLACEHOLDER_REGEX = '/:([^\/]+)\/?/';

    /**
     * [$method description]
     * @var string
     */
    private $method;

    /**
     * [$path description]
     * @var string
     */
    private $path;

    /**
     * [$callback description]
     * @var callable
     */
    private $callback;

    /**
     * [$allowedMethods description]
     * @var array
     */
    protected static $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS'];

    /**
     * [__construct description]
     * @param string   $method   [description]
     * @param string   $path     [description]
     * @param callable $callback [description]
     */
    public function __construct($method, $path, $callback)
    {
        $this->setMethod($method);
        $this->setPath($path);
        $this->setCallback($callback);
    }

    /**
     * [setMethod description]
     * @throws InvalidArgumentException
     * @param string $method [description]
     */
    public function setMethod($method)
    {
        $method = strtoupper((string) $method);

        if (!in_array($method, static::$allowedMethods, true)) {
            throw new InvalidArgumentException('A valid HTTP method was not provided.');
        }

        $this->method = $method;

        return $this;
    }

    /**
     * [getMethod description]
     * @return string [description]
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * [setPath description]
     * @param string $path [description]
     */
    public function setPath($path)
    {
        $this->path = (string) $path;

        return $this;
    }

    /**
     * [getPath description]
     * @return string [description]
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * [setCallback description]
     * @param callable $callback [description]
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * [getCallback description]
     * @return callable [description]
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * [getPattern description]
     * @return string [description]
     */
    public function getPattern()
    {
        // escape and remove trailing slashes
        $path = str_replace('/', '\/', $this->getPath());

        // replace named placeholders
        if (preg_match_all(self::NAMED_PLACEHOLDER_REGEX, $path, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $path = str_replace(rtrim($match[0], '/'), '([^\/]+)', $path);
            }
        }

        return '/^' . $path . '$/';
    }
}
