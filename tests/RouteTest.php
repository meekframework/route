<?php

namespace Meek\Routing;

use PHPUnit\Framework\TestCase;
use Meek\Routing\Rule\MatchMethod;

class RouteTest extends TestCase
{
    private $route;

    public function setUp()
    {
        $this->route = new Route('test.route', '/', function () {});
    }

    public function testCanRetrieveName()
    {
        $this->assertEquals('test.route', $this->route->getName());
    }

    public function testCanRetrievePath()
    {
        $this->assertEquals('/', $this->route->getPath());
    }

    public function testCanRetrievePatternForBasicPath()
    {
        $this->assertEquals('/^\/$/', $this->route->getPattern());
    }

    public function testExtractsNamedPlaceholdersFromPathAndAddsToAttributes()
    {
        $route = new Route('test.route', '/api/:version/users/:id', function () {});
        $expected = ['version' => null, 'id' => null];
        $this->assertTrue($expected == $route->getAttributes());
    }

    public function testCanRetrieveCallback()
    {
        $callback = function () { return 'Hello, World!'; };
        $route = new Route('test.route', '/', $callback);
        $this->assertSame($callback, $route->getCallback());
    }

    public function testRouteDefaultsToNoMethods()
    {
        $this->assertEmpty($this->route->getMethods());
    }

    public function testAddingMethodToRouteIsNormalizedToUpperCase()
    {
        $this->route->addMethod('get');
        $this->assertTrue(in_array('GET', $this->route->getMethods()));
    }

    public function testAddingGETMethodToRouteAlsoAddsHEADMethod()
    {
        $this->route->addMethod('GET');
        $this->assertTrue(in_array('HEAD', $this->route->getMethods()));
    }

    public function testErrorIsThrownWhenTryingToAddAnUnallowedMethod()
    {
        $this->expectException('InvalidArgumentException');
        $this->route->addMethod('CONNECT');
    }

    public function testRouteDefaultsToNoAttributes()
    {
        $this->assertEmpty($this->route->getAttributes());
    }

    public function testCanAddAttributeWithoutValue()
    {
        $this->route->addAttribute('test');
        $this->assertSame(null, $this->route->getAttributes()['test']);
    }

    public function testCanOnlyAddCallableRules()
    {
        $this->expectException('PHPUnit_Framework_Error');
        $this->route->addRule('Boo!');
    }

    public function testCanAddRule()
    {
        $rule = new MatchMethod();
        $this->route->addRule($rule);
        $this->assertSame($rule, $this->route->getRules()[0]);
    }

    public function testRouteDefaultsToNoRules()
    {
        $this->assertEmpty($this->route->getRules());
    }
}
