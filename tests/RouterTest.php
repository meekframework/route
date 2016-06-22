<?php

namespace Meek\Routing;

use PHPUnit\Framework\TestCase;
use Meek\Routing\Route\Collection;
use Meek\Routing\Route\Matcher;
use Meek\Routing\Route\Dispatcher;
use Meek\Routing\Path\Generator;
use Zend\Diactoros\ServerRequest;

class RouterTest extends TestCase
{
    private $router;

    public function setUp()
    {
        $this->router = Router::create();
    }

    public function testFactoryMethod()
    {
        $this->assertInstanceOf(Router::class, $this->router);
    }

    public function testCanRetrieveRoutes()
    {
        $this->assertInstanceOf(Collection::class, $this->router->getRoutes());
    }

    public function testCanRetrieveMatcher()
    {
        $this->assertInstanceOf(Matcher::class, $this->router->getMatcher());
    }

    public function testCanRetrieveDispatcher()
    {
        $this->assertInstanceOf(Dispatcher::class, $this->router->getDispatcher());
    }

    public function testCanRetrieveGenerator()
    {
        $this->assertInstanceOf(Generator::class, $this->router->getGenerator());
    }

    public function testProxiesMatcher()
    {
        $route = new Route('test.route', '/', function () {});
        $collection = new Collection([$route]);
        $request = $this->getRequestWithPath('/');

        $matcher = $this->createMock(Matcher::class);
        $matcher->expects($this->once())
            ->method('match')
            ->with($request);

        $router = new Router($collection, $matcher, new Dispatcher($matcher), new Generator($collection));
        $router->match($request);
    }

    public function testProxiesDispatcher()
    {
        $route = new Route('test.route', '/', function () {});
        $collection = new Collection([$route]);
        $request = $this->getRequestWithPath('/');

        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($request);

        $router = new Router($collection, new Matcher($collection), $dispatcher, new Generator($collection));
        $router->dispatch($request);
    }

    public function testProxiesGenerator()
    {
        $route = new Route('test.route', '/:test', function () {});
        $collection = new Collection([$route]);
        $request = $this->getRequestWithPath('/');
        $matcher = new Matcher($collection);

        $generator = $this->createMock(Generator::class);
        $generator->expects($this->once())
            ->method('generate')
            ->with('test.route', ['test' => 'tested']);

        $router = new Router($collection, $matcher, new Dispatcher($matcher), $generator);
        $router->generate('test.route', ['test' => 'tested']);
    }

    public function testRouterProxiesUnknownMethodsToRouteCollection()
    {
        $route = new Route('test.route', '/', function () {});
        $collection = $this->createMock(Collection::class);
        $collection->method('add')
            ->willReturn($route);

        $matcher = new Matcher($collection);
        $router = new Router($collection, $matcher, new Dispatcher($matcher), new Generator($collection));

        $this->assertSame($route, $router->add($route));
    }

    private function getRequestWithPath($path)
    {
        return new ServerRequest([], [], $path);
    }
}
