<?php

namespace Meek\Routing\Route;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequest;
use Meek\Routing\Route;

class DispatcherTest extends TestCase
{
    public function testDispatchesCallbackIfRouteMatched()
    {
        $route = new Route('test.route', '/', function () {
            return 'Hello, World!';
        });

        $dispatcher = new Dispatcher($this->getMatcherWithRoute($route));
        $this->expectOutputString('Hello, World!');
        $dispatcher->dispatch($this->getRequestWithPath('/'));
    }

    public function testRouteAttributesAreAddedToRequest()
    {
        $returnedRequest = null;
        $route = new Route(
            'test.route',
            '/api/:version/users/:id',
            function (ServerRequestInterface $request) use (&$returnedRequest) {
                $returnedRequest = $request;
            }
        );

        $dispatcher = new Dispatcher($this->getMatcherWithRoute($route));
        $dispatcher->dispatch($this->getRequestWithPath('/api/v3/users/65535'));
        $this->assertEquals(['version' => 'v3', 'id' => '65535'], $returnedRequest->getAttributes());
    }

    private function getMatcherWithRoute(Route $route)
    {
        return new Matcher(new Collection([$route]));
    }

    private function getRequestWithPath($path)
    {
        return new ServerRequest([], [], $path);
    }
}
