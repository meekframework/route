<?php declare(strict_types=1);

namespace Meek\Route;

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\TextResponse;

class DispatcherTest extends TestCase
{
    /**
     * @covers \Meek\Route\Dispatcher::__construct
     * @covers \Meek\Route\Dispatcher::dispatch
     */
    public function testRouteHandlerIsInvokedIfMatchesRequest()
    {
        $handlerCalled = false;
        $routeCollection = new Collection();
        $matcher = new Matcher($routeCollection);
        $dispatcher = new Dispatcher($matcher);
        $testRoute = new Route('get', '/', function () use (&$handlerCalled) {
            $handlerCalled = true;

            return new TextResponse('Hello, world!');
        });

        $routeCollection->add($testRoute);
        $dispatcher->dispatch($this->createServerRequest('get', '/'));

        $this->assertTrue($handlerCalled);
    }

    /**
     * @covers \Meek\Route\Dispatcher::dispatch
     */
    public function testThrowsExceptionIfHandlerDoesNotReturnAPsrResponse()
    {
        $routeCollection = new Collection();
        $matcher = new Matcher($routeCollection);
        $dispatcher = new Dispatcher($matcher);
        $testRoute = new Route('get', '/', function () {
            return 'Hello, world!';
        });

        $routeCollection->add($testRoute);

        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('Response was not an instance of PSR\Http\Message\ResponseInterface');

        $dispatcher->dispatch($this->createServerRequest('get', '/'));
    }

    /**
     * @covers \Meek\Route\Dispatcher::dispatch
     */
    public function testRequestPassedToRouteHandlerContainsParsedPlaceholderValues()
    {
        $attributes = [];
        $routeCollection = new Collection();
        $matcher = new Matcher($routeCollection);
        $dispatcher = new Dispatcher($matcher);
        $testRoute = new Route('get', '/api/:version/users/:id', function ($request) use (&$attributes) {
            $attributes = $request->getAttributes();

            return new TextResponse('Hello, world!');
        });

        $routeCollection->add($testRoute);
        $dispatcher->dispatch($this->createServerRequest('get', '/api/v3/users/485'));

        $this->assertEquals(['version' => 'v3', 'id' => '485'], $attributes);
    }

    private function createServerRequest(string $method, string $target)
    {
        return (new ServerRequest())->withMethod($method)->withRequestTarget($target);
    }
}
