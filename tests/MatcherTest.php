<?php declare(strict_types=1);

namespace Meek\Route;

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class MatcherTest extends TestCase
{
    private $testRoute;
    private $routeCollection;

    public function setUp()
    {
        $this->testRoute = new Route('get', '/', function () {});
        $this->routeCollection = new Collection();

        $this->routeCollection->add($this->testRoute);
    }

    /**
     * @covers \Meek\Route\Matcher::matchRequestTarget
     */
    public function testThrowsExceptionIfRequestTargetNotMatched()
    {
        $matcher = new Matcher($this->routeCollection);

        $this->expectException(TargetNotMatched::class);

        $matcher->match($this->createServerRequest('get', '/test'));
    }

    /**
     * @covers \Meek\Route\Matcher::matchRequestMethod
     */
    public function testThrowsExceptionIfRequestMethodNotMatched()
    {
        $matcher = new Matcher($this->routeCollection);

        $this->expectException(MethodNotMatched::class);

        $matcher->match($this->createServerRequest('put', '/'));
    }

    /**
     * @covers \Meek\Route\Matcher::__construct
     * @covers \Meek\Route\Matcher::match
     * @covers \Meek\Route\Matcher::matchRequestTarget
     * @covers \Meek\Route\Matcher::matchRequestMethod
     */
    public function testMatchedRouteIsReturned()
    {
        $matcher = new Matcher($this->routeCollection);

        $route = $matcher->match($this->createServerRequest('get', '/'));

        $this->assertSame($this->testRoute, $route);
    }

    /**
     * @covers \Meek\Route\Matcher::matchRequestMethod
     */
    public function testGetRouteRespondsToAHeadRequestMethod()
    {
        $matcher = new Matcher($this->routeCollection);

        $route = $matcher->match($this->createServerRequest('head', '/'));

        $this->assertSame($this->testRoute, $route);
    }

    /**
     * @covers \Meek\Route\Matcher::matchRequestMethod
     */
    public function testAllowedMethodsIsAddedToMethodNotMatchedException()
    {
        $routeCollection = new Collection();
        $request = $this->createServerRequest('get', '/');
        $methodNotMatched = null;
        $matcher = new Matcher($routeCollection);

        $routeCollection->add(new Route('post', '/', function () {}));
        $routeCollection->add(new Route('put', '/', function () {}));
        $routeCollection->add(new Route('patch', '/', function () {}));
        $routeCollection->add(new Route('delete', '/', function () {}));

        try {
            $matchedRoute = $matcher->match($request);
        } catch (MethodNotMatched $e) {
            $methodNotMatched = $e;
        }

        $this->assertEquals(['POST', 'PUT', 'PATCH', 'DELETE'], $methodNotMatched->getAllowedMethods());
    }

    /**
     * @covers \Meek\Route\Matcher::matchRequestTarget
     * @covers \Meek\Route\Matcher::getPattern
     * @covers \Meek\Route\Matcher::extractPlaceholderValues
     */
    public function testPlaceholdersAreExtractedAndAddedToRouteAttributes()
    {
        $testRoute = new Route('get', '/api/:version/users/:id', function () {});
        $routeCollection = new Collection();
        $matcher = new Matcher($routeCollection);
        $expected = ['version' => 'v3', 'id' =>'465'];
        $request = $this->createServerRequest('get', '/api/v3/users/465');

        $routeCollection->add($testRoute);
        $matchedRoute = $matcher->match($request);

        $this->assertEquals($expected, $matchedRoute->getAttributes());
    }

    private function createServerRequest(string $method, string $target)
    {
        return (new ServerRequest())->withMethod($method)->withRequestTarget($target);
    }
}
