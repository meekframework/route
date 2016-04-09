<?php declare(strict_types=1);

namespace Meek\Route;

use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    private $basicRoute;
    private $complexRoute;

    public function setUp()
    {
        $this->basicRoute = new Route('get', '/posts', function () {});
        $this->complexRoute = new Route('get', '/api/:version/users/:id', function () {});
    }

    /**
     * @coversNothing
     */
    public function testCollectionCanBeIteratedOver()
    {
        $routeCollection = new Collection();

        $this->assertInstanceOf('IteratorAggregate', $routeCollection);
    }

    /**
     * @coversNothing
     */
    public function testCollectionIsCountable()
    {
        $routeCollection = new Collection();

        $this->assertInstanceOf('Countable', $routeCollection);
    }

    /**
     * @covers \Meek\Route\Collection::__construct
     */
    public function testCollectionIsInitiallyEmpty()
    {
        $routeCollection = new Collection();

        $this->assertEmpty($routeCollection);
    }

    /**
     * @covers \Meek\Route\Collection::__construct
     */
    public function testInitialisingCollectionWithRoutesAddsThemToCollection()
    {
        $routeCollection = new Collection([$this->basicRoute, $this->complexRoute]);

        $this->assertTrue($routeCollection->contains($this->basicRoute));
        $this->assertTrue($routeCollection->contains($this->complexRoute));
    }

    /**
     * @covers \Meek\Route\Collection::add
     */
    public function testCanAddRouteToCollection()
    {
        $routeCollection = new Collection();

        $routeCollection->add($this->basicRoute);

        $this->assertTrue($routeCollection->contains($this->basicRoute));
    }

    /**
     * @covers \Meek\Route\Collection::remove
     */
    public function testThrowsExceptionWhenTryingToRemoveNonExistentRouteFromCollection()
    {
        $routeCollection = new Collection();

        $this->expectException('LogicException');
        $this->expectExceptionMessage('Cannot remove non-existent route');

        $routeCollection->remove($this->basicRoute);
    }

    /**
     * @covers \Meek\Route\Collection::remove
     */
    public function testCanRemoveRouteFromCollection()
    {
        $routeCollection = new Collection([$this->basicRoute]);

        $routeCollection->remove($this->basicRoute);

        $this->assertFalse($routeCollection->contains($this->basicRoute));
    }

    /**
     * @covers \Meek\Route\Collection::contains
     */
    public function testCollectionContainsRouteIfBeenAdded()
    {
        $routeCollection = new Collection();

        $routeCollection->add($this->basicRoute);

        $this->assertTrue($routeCollection->contains($this->basicRoute));
    }

    /**
     * @covers \Meek\Route\Collection::contains
     */
    public function testCollectionDoesNotContainRouteIfNotAdded()
    {
        $routeCollection = new Collection();

        $this->assertFalse($routeCollection->contains($this->basicRoute));
    }

    /**
     * @covers \Meek\Route\Collection::count
     */
    public function testCollectionInitiallyContainsNothing()
    {
        $routeCollection = new Collection();


        $this->assertCount(0, $routeCollection);
    }

    /**
     * @covers \Meek\Route\Collection::count
     */
    public function testAddingRouteIncreasesCount()
    {
        $routeCollection = new Collection();

        $routeCollection->add($this->basicRoute);

        $this->assertCount(1, $routeCollection);
    }

    /**
     * @covers \Meek\Route\Collection::count
     */
    public function testRemovingRouteDecreasesCount()
    {
        $routeCollection = new Collection([$this->basicRoute]);

        $routeCollection->remove($this->basicRoute);

        $this->assertCount(0, $routeCollection);
    }

    /**
     * @covers \Meek\Route\Collection::getIterator
     */
    public function testCollectionIteratesOverRoutesInOrderTheyWereAdded()
    {
        $routeCollection = new Collection([$this->basicRoute, $this->complexRoute]);
        $collectionIterator = $routeCollection->getIterator();

        $this->assertSame($this->basicRoute, $collectionIterator->current());

        $collectionIterator->next();

        $this->assertSame($this->complexRoute, $collectionIterator->current());
    }
}
