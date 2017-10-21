<?php declare(strict_types=1);

namespace Meek\Route;

use PHPUnit\Framework\TestCase;

class UrlGeneratorTest extends TestCase
{
    private $basicRoute;
    private $complexRoute;
    private $routeCollection;

    public function setUp()
    {
        $this->basicRoute = new Route('get', '/posts', function () {});
        $this->complexRoute = new Route('get', '/api/:version/users/:id', function () {});
        $this->routeCollection = new Collection();

        // basic route
        $this->basicRoute->setName('test.route.basic');
        $this->routeCollection->add($this->basicRoute);

        // route with placeholders
        $this->complexRoute->setName('test.route.complex');
        $this->routeCollection->add($this->complexRoute);
    }

    /**
     * @covers \Meek\Route\UrlGenerator::generate
     */
    public function testThrowsExceptionForUnknownRouteName()
    {
        $urlGenerator = new UrlGenerator($this->routeCollection);

        $this->expectException('RuntimeException');

        $urlGenerator->generate('non.existant.route');
    }

    /**
     * @covers \Meek\Route\UrlGenerator::__construct
     * @covers \Meek\Route\UrlGenerator::generate
     */
    public function testGeneratesUrlForNamedRoute()
    {
        $urlGenerator = new UrlGenerator($this->routeCollection);

        $this->assertEquals('/posts', $urlGenerator->generate('test.route.basic'));
    }

    /**
     * @covers \Meek\Route\UrlGenerator::interpolate
     */
    public function testInterpolatesPlaceholdersCorrectly()
    {
        $urlGenerator = new UrlGenerator($this->routeCollection);
        $params = ['version' => 'v3', 'id' => 65535];

        $this->assertEquals('/api/v3/users/65535', $urlGenerator->generate('test.route.complex', $params));
    }
}
