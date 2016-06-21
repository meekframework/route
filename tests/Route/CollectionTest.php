<?php

namespace Meek\Routing\Route;

use PHPUnit\Framework\TestCase;
use Meek\Routing\Route;

class CollectionTest extends TestCase
{
    private $routes;

    public function setUp()
    {
        $this->routes = new Collection();
    }
}
