<?php declare(strict_types=1);

namespace Meek\Route;

use PHPUnit\Framework\TestCase;

class MapperTest extends TestCase
{
    private $routeCollection;
    private $routeMapper;

    public function setUp()
    {
        $this->routeCollection = new Collection();
        $this->routeMapper = new Mapper($this->routeCollection);
    }

    /**
     * @covers \Meek\Route\Mapper::__construct
     */
    public function testCollectionIsSet()
    {
        $routeMapper = new Mapper($this->routeCollection);

        $this->assertSame($this->routeCollection, $this->routeMapper->getCollection());
    }

    /**
     * @covers \Meek\Route\Mapper::head
     */
    public function testHeadMethod_AddsMethodToRouteObject()
    {
        $addedRoute = $this->routeMapper->head('/test/route', function () {});

        $this->assertEquals('HEAD', $addedRoute->getMethod());
    }

    /**
     * @covers \Meek\Route\Mapper::head
     */
    public function testHeadMethod_AddsPathToRouteObject()
    {
        $addedRoute = $this->routeMapper->head('/test/route', function () {});

        $this->assertEquals('/test/route', $addedRoute->getPath());
    }

    /**
     * @covers \Meek\Route\Mapper::head
     */
    public function testHeadMethod_AddsHandlerToRouteObject()
    {
        $noop = function () {};
        $addedRoute = $this->routeMapper->head('/test/route', $noop);

        $this->assertSame($noop, $addedRoute->getHandler());
    }

    /**
     * @covers \Meek\Route\Mapper::head
     */
    public function testHeadMethod_AddsRouteObjectToCollection()
    {
        $addedRoute = $this->routeMapper->head('/test/route', function () {});

        $this->assertTrue($this->routeCollection->contains($addedRoute));
    }

    /**
     * @covers \Meek\Route\Mapper::head
     */
    public function testHeadMethod_ReturnsAddedRouteObject()
    {
        $addedRoute = $this->routeMapper->head('/test/route', function () {});

        $this->assertInstanceOf(Route::class, $addedRoute);
    }

    /**
     * @covers \Meek\Route\Mapper::get
     */
    public function testGetMethod_AddsMethodToRouteObject()
    {
        $addedRoute = $this->routeMapper->get('/test/route', function () {});

        $this->assertEquals('GET', $addedRoute->getMethod());
    }

    /**
     * @covers \Meek\Route\Mapper::get
     */
    public function testGetMethod_AddsPathToRouteObject()
    {
        $addedRoute = $this->routeMapper->get('/test/route', function () {});

        $this->assertEquals('/test/route', $addedRoute->getPath());
    }

    /**
     * @covers \Meek\Route\Mapper::get
     */
    public function testGetMethod_AddsHandlerToRouteObject()
    {
        $noop = function () {};
        $addedRoute = $this->routeMapper->get('/test/route', $noop);

        $this->assertSame($noop, $addedRoute->getHandler());
    }

    /**
     * @covers \Meek\Route\Mapper::get
     */
    public function testGetMethod_AddsRouteObjectToCollection()
    {
        $addedRoute = $this->routeMapper->get('/test/route', function () {});

        $this->assertTrue($this->routeCollection->contains($addedRoute));
    }

    /**
     * @covers \Meek\Route\Mapper::get
     */
    public function testGetMethod_ReturnsAddedRouteObject()
    {
        $addedRoute = $this->routeMapper->get('/test/route', function () {});

        $this->assertInstanceOf(Route::class, $addedRoute);
    }

    /**
     * @covers \Meek\Route\Mapper::post
     */
    public function testPostMethod_AddsMethodToRouteObject()
    {
        $addedRoute = $this->routeMapper->post('/test/route', function () {});

        $this->assertEquals('POST', $addedRoute->getMethod());
    }

    /**
     * @covers \Meek\Route\Mapper::post
     */
    public function testPostMethod_AddsPathToRouteObject()
    {
        $addedRoute = $this->routeMapper->post('/test/route', function () {});

        $this->assertEquals('/test/route', $addedRoute->getPath());
    }

    /**
     * @covers \Meek\Route\Mapper::post
     */
    public function testPostMethod_AddsHandlerToRouteObject()
    {
        $noop = function () {};
        $addedRoute = $this->routeMapper->post('/test/route', $noop);

        $this->assertSame($noop, $addedRoute->getHandler());
    }

    /**
     * @covers \Meek\Route\Mapper::post
     */
    public function testPostMethod_AddsRouteObjectToCollection()
    {
        $addedRoute = $this->routeMapper->post('/test/route', function () {});

        $this->assertTrue($this->routeCollection->contains($addedRoute));
    }

    /**
     * @covers \Meek\Route\Mapper::post
     */
    public function testPostMethod_ReturnsAddedRouteObject()
    {
        $addedRoute = $this->routeMapper->post('/test/route', function () {});

        $this->assertInstanceOf(Route::class, $addedRoute);
    }

    /**
     * @covers \Meek\Route\Mapper::put
     */
    public function testPutMethod_AddsMethodToRouteObject()
    {
        $addedRoute = $this->routeMapper->put('/test/route', function () {});

        $this->assertEquals('PUT', $addedRoute->getMethod());
    }

    /**
     * @covers \Meek\Route\Mapper::put
     */
    public function testPutMethod_AddsPathToRouteObject()
    {
        $addedRoute = $this->routeMapper->put('/test/route', function () {});

        $this->assertEquals('/test/route', $addedRoute->getPath());
    }

    /**
     * @covers \Meek\Route\Mapper::put
     */
    public function testPutMethod_AddsHandlerToRouteObject()
    {
        $noop = function () {};
        $addedRoute = $this->routeMapper->put('/test/route', $noop);

        $this->assertSame($noop, $addedRoute->getHandler());
    }

    /**
     * @covers \Meek\Route\Mapper::put
     */
    public function testPutMethod_AddsRouteObjectToCollection()
    {
        $addedRoute = $this->routeMapper->put('/test/route', function () {});

        $this->assertTrue($this->routeCollection->contains($addedRoute));
    }

    /**
     * @covers \Meek\Route\Mapper::put
     */
    public function testPutMethod_ReturnsAddedRouteObject()
    {
        $addedRoute = $this->routeMapper->put('/test/route', function () {});

        $this->assertInstanceOf(Route::class, $addedRoute);
    }

    /**
     * @covers \Meek\Route\Mapper::patch
     */
    public function testPatchMethod_AddsMethodToRouteObject()
    {
        $addedRoute = $this->routeMapper->patch('/test/route', function () {});

        $this->assertEquals('PATCH', $addedRoute->getMethod());
    }

    /**
     * @covers \Meek\Route\Mapper::patch
     */
    public function testPatchMethod_AddsPathToRouteObject()
    {
        $addedRoute = $this->routeMapper->patch('/test/route', function () {});

        $this->assertEquals('/test/route', $addedRoute->getPath());
    }

    /**
     * @covers \Meek\Route\Mapper::patch
     */
    public function testPatchMethod_AddsHandlerToRouteObject()
    {
        $noop = function () {};
        $addedRoute = $this->routeMapper->patch('/test/route', $noop);

        $this->assertSame($noop, $addedRoute->getHandler());
    }

    /**
     * @covers \Meek\Route\Mapper::patch
     */
    public function testPatchMethod_AddsRouteObjectToCollection()
    {
        $addedRoute = $this->routeMapper->patch('/test/route', function () {});

        $this->assertTrue($this->routeCollection->contains($addedRoute));
    }

    /**
     * @covers \Meek\Route\Mapper::patch
     */
    public function testPatchMethod_ReturnsAddedRouteObject()
    {
        $addedRoute = $this->routeMapper->patch('/test/route', function () {});

        $this->assertInstanceOf(Route::class, $addedRoute);
    }

    /**
     * @covers \Meek\Route\Mapper::delete
     */
    public function testDeleteMethod_AddsMethodToRouteObject()
    {
        $addedRoute = $this->routeMapper->delete('/test/route', function () {});

        $this->assertEquals('DELETE', $addedRoute->getMethod());
    }

    /**
     * @covers \Meek\Route\Mapper::delete
     */
    public function testDeleteMethod_AddsPathToRouteObject()
    {
        $addedRoute = $this->routeMapper->delete('/test/route', function () {});

        $this->assertEquals('/test/route', $addedRoute->getPath());
    }

    /**
     * @covers \Meek\Route\Mapper::delete
     */
    public function testDeleteMethod_AddsHandlerToRouteObject()
    {
        $noop = function () {};
        $addedRoute = $this->routeMapper->delete('/test/route', $noop);

        $this->assertSame($noop, $addedRoute->getHandler());
    }

    /**
     * @covers \Meek\Route\Mapper::delete
     */
    public function testDeleteMethod_AddsRouteObjectToCollection()
    {
        $addedRoute = $this->routeMapper->delete('/test/route', function () {});

        $this->assertTrue($this->routeCollection->contains($addedRoute));
    }

    /**
     * @covers \Meek\Route\Mapper::delete
     */
    public function testDeleteMethod_ReturnsAddedRouteObject()
    {
        $addedRoute = $this->routeMapper->delete('/test/route', function () {});

        $this->assertInstanceOf(Route::class, $addedRoute);
    }

    /**
     * @covers \Meek\Route\Mapper::options
     */
    public function testOptionsMethod_AddsMethodToRouteObject()
    {
        $addedRoute = $this->routeMapper->options('/test/route', function () {});

        $this->assertEquals('OPTIONS', $addedRoute->getMethod());
    }

    /**
     * @covers \Meek\Route\Mapper::options
     */
    public function testOptionsMethod_AddsPathToRouteObject()
    {
        $addedRoute = $this->routeMapper->options('/test/route', function () {});

        $this->assertEquals('/test/route', $addedRoute->getPath());
    }

    /**
     * @covers \Meek\Route\Mapper::options
     */
    public function testOptionsMethod_AddsHandlerToRouteObject()
    {
        $noop = function () {};
        $addedRoute = $this->routeMapper->options('/test/route', $noop);

        $this->assertSame($noop, $addedRoute->getHandler());
    }

    /**
     * @covers \Meek\Route\Mapper::options
     */
    public function testOptionsMethod_AddsRouteObjectToCollection()
    {
        $addedRoute = $this->routeMapper->options('/test/route', function () {});

        $this->assertTrue($this->routeCollection->contains($addedRoute));
    }

    /**
     * @covers \Meek\Route\Mapper::options
     */
    public function testOptionsMethod_ReturnsAddedRouteObject()
    {
        $addedRoute = $this->routeMapper->options('/test/route', function () {});

        $this->assertInstanceOf(Route::class, $addedRoute);
    }

    /**
     * @covers \Meek\Route\Mapper::getCollection
     */
    public function testCanRetrieveRouteCollection()
    {
        $this->assertSame($this->routeCollection, $this->routeMapper->getCollection());
    }
}
