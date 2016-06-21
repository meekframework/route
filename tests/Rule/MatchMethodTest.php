<?php

namespace Meek\Routing\Rule;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Meek\Routing\Route;

class MatchMethodTest extends TestCase
{
    private $rule;

    public function setUp()
    {
        $this->rule = new MatchMethod();
    }

    public function testIsCallable()
    {
        $this->assertTrue(is_callable($this->rule));
    }

    public function testReturnsTrueIfRequestMethodIsInRoute()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getMethod')->willReturn('GET');
        $route = (new Route('test.route', '/', function () {}))->addMethod('get');
        $this->assertTrue(call_user_func($this->rule, $request, $route));
    }

    public function testReturnsFalseIfRequestMethodIsNotInRoute()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getMethod')->willReturn('GET');
        $route = new Route('test.route', '/', function () {});
        $this->assertFalse(call_user_func($this->rule, $request, $route));
    }
}
