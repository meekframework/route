<?php declare(strict_types=1);

namespace Meek\Route;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Dispatches matched routes.
 *
 * @author Nathan Bishop <nbish11@hotmail.com> (https://nathanbishop.name)
 * @copyright 2016 Nathan Bishop
 * @license The MIT license.
 */
class Dispatcher
{
    /**
     * @var Matcher [description]
     */
    private $matcher;

    /**
     * Creates a new route dispatcher.
     *
     * @param Matcher $matcher [description]
     */
    public function __construct(Matcher $matcher)
    {
        $this->matcher = $matcher;
    }

    /**
     * Dispatches the matched route, or handles a failed one.
     *
     * @param ServerRequestInterface $request The request object to match against and pass to the callback.
     * @return ResponseInterface [<description>]
     */
    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        $matchedRoute = $this->matcher->match($request);

        foreach ($matchedRoute->getAttributes() as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }

        $response = $matchedRoute->getHandler()($request);

        if (!($response instanceof ResponseInterface)) {
            throw new RuntimeException('Response was not an instance of PSR\Http\Message\ResponseInterface');
        }

        return $response;
    }
}
