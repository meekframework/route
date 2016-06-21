<?php

namespace Meek\Routing;

use PHPUnit\Framework\TestCase;
use Meek\Routing\Route\Collection;
use Meek\Routing\Route\Matcher;
use Meek\Routing\Route\Dispatcher;
use Meek\Routing\Path\Generator;

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
}
