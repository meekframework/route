<?php

namespace Meek\Routing\Route;

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;
use Meek\Routing\Route;

class MatcherTest extends TestCase
{
    private $route;
    private $matcher;

    public function setUp()
    {
        $this->route = new Route('test.route', '/', function () {});
        $this->matcher = new Matcher(new Collection([$this->route]));
    }

    public function testReturnsNullIfRouteCollectionIsEmpty()
    {
        $matcher = new Matcher(new Collection());
        $request = $this->getRequestWithPath('/');

        $this->assertSame(null, $matcher->match($request));
    }

    public function testReturnsNullIfRouteCouldNotBeFoundForCurrentRequest()
    {
        $request = $this->getRequestWithPath('/does-not-exist');
        $this->assertSame(null, $this->matcher->match($request));
    }

    public function testReturnsMatchedRoute()
    {
        $request = $this->getRequestWithPath('/');
        $this->assertSame($this->route, $this->matcher->match($request));
    }

    public function testRouteAttributesArePopulatedWithValues()
    {
        $route = new Route('test.route', '/api/:version/users/:id', function () {});
        $matcher = new Matcher(new Collection([$route]));
        $request = $this->getRequestWithPath('/api/v3/users/65535');
        $matcher->match($request);
        $this->assertEquals(['version' => 'v3', 'id' => '65535'], $route->getAttributes());
    }

    private function getRequestWithPath($path)
    {
        return new ServerRequest([], [], $path);
    }
}
