<?php

namespace Meek\Routing\Path;

use PHPUnit\Framework\TestCase;
use Meek\Routing\Route\Collection;

class GeneratorTest extends TestCase
{
    private $routes;

    public function setUp()
    {
        $this->routes = new Collection();
        $this->generator = new Generator($this->routes);
    }

    public function testThrowsErrorForUnknownRouteName()
    {
        $this->expectException('RuntimeException');
        $this->generator->generate('non.existant.route');
    }

    public function testInterpolatesPlaceholdersCorrectly()
    {
        $this->routes->map('test.route', '/api/:version/users/:id', function () {});
        $context = ['version' => 'v3', 'id' => 65535];
        $actual = $this->generator->generate('test.route', $context);
        $this->assertEquals('/api/v3/users/65535', $actual);
    }
}
