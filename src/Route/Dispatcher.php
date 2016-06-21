<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2016 Nathan Bishop
 */
namespace Meek\Routing\Route;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Dispatches and handles matched or failed routes.
 *
 * @version 0.1.0
 * @author Nathan Bishop (nbish11)
 * @copyright 2016 Nathan Bishop
 * @license MIT
 */
class Dispatcher
{
    /**
     * The "matcher" object.
     *
     * @var Matcher
     */
    private $matcher;

    /**
     * Constructs a new route dispatcher.
     *
     * @param Matcher $matcher The route matcher object.
     */
    public function __construct(Matcher $matcher)
    {
        $this->matcher = $matcher;
    }

    /**
     * Dispatches the matched route, or handles a failed one.
     *
     * @param ServerRequestInterface $request The request object to match
     *                                        against and pass to the callback.
     */
    public function dispatch(ServerRequestInterface $request)
    {
        if ($route = $this->matcher->match($request)) {
            foreach ($route->getAttributes() as $key => $value) {
                $request = $request->withAttribute($key, $value);
            }

            echo call_user_func($route->getCallback(), $request);
        }
    }
}
