<?php declare(strict_types=1);

namespace Meek\Route;

use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    /**
     * @covers \Meek\Route\Route::__construct
     */
    public function testMethodIsNormalisedToUpperCase()
    {
        $route = new Route('post', '*', function () {});

        $this->assertEquals('POST', $route->getMethod());
    }

    /**
     * @covers \Meek\Route\Route::__construct
     */
    public function testThrowsExceptionIfPathDoesNotStartWithSlash()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Path must either be an asterix ("*") or begin with a slash("/")');

        $route = new Route('get', 'posts', function () {});
    }

    /**
     * @covers \Meek\Route\Route::__construct
     */
    public function testDoesNotThrowExceptionIfPathIsAnAsterix()
    {
        $route = new Route('get', '*', function () {});

        $this->assertEquals('*', $route->getPath());
    }

    /**
     * @covers \Meek\Route\Route::__construct
     */
    public function testRouteIsInitialisedWithNoAttributes()
    {
        $route = new Route('get', '/', function () {});

        $this->assertEmpty($route->getAttributes());
    }

    /**
     * @covers \Meek\Route\Route::getMethod
     */
    public function testCanGetMethod()
    {
        $route = new Route('get', '*', function () {});

        $this->assertEquals('GET', $route->getMethod());
    }

    /**
     * @covers \Meek\Route\Route::getPath
     */
    public function testCanGetPath()
    {
        $route = new Route('get', '/posts', function () {});

        $this->assertEquals('/posts', $route->getPath());
    }

    /**
     * @covers \Meek\Route\Route::getHandler
     */
    public function testCanGetHandler()
    {
        $handler = function () {};
        $route = new Route('get', '*', $handler);

        $this->assertSame($handler, $route->getHandler());
    }

    /**
     * @covers \Meek\Route\Route::setName
     */
    public function testCanNameRoute()
    {
        $route = new Route('get', '/', function () {});
        $route->setName('test.route');

        $this->assertEquals('test.route', $route->getName());
    }

    /**
     * @covers \Meek\Route\Route::setName
     */
    public function testThrowsExceptionIfNameIsEmpty()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Route name cannot be empty');

        $route = new Route('get', '/', function () {});
        $route->setName('');
    }

    /**
     * @covers \Meek\Route\Route::getName
     */
    public function testCanGetRouteName()
    {
        $route = new Route('get', '/', function () {});
        $route->setName('test.route');

        $this->assertEquals('test.route', $route->getName());
    }

    /**
     * @covers \Meek\Route\Route::setAttributes
     */
    public function testCanSetAttributes()
    {
        $parsedPlaceholders = ['version' => 'v3', 'id' => '465'];
        $route = new Route('get', '/', function () {});

        $route->setAttributes($parsedPlaceholders);

        $this->assertEquals($parsedPlaceholders, $route->getAttributes());
    }

    /**
     * @covers \Meek\Route\Route::getAttributes
     */
    public function testCanGetAttributes()
    {
        $parsedPlaceholders = ['version' => 'v3', 'id' => '465'];
        $route = new Route('get', '/', function () {});

        $route->setAttributes($parsedPlaceholders);

        $this->assertEquals($parsedPlaceholders, $route->getAttributes());
    }
}
