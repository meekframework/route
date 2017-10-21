<?php declare(strict_types=1);

namespace Meek\Route;

use PHPUnit\Framework\TestCase;

class TargetNotMatchedTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testIsARuntimeException()
    {
        $targetNotMatched = new TargetNotMatched('/');

        $this->assertInstanceOf('RuntimeException', $targetNotMatched);
    }

    /**
     * @covers \Meek\Route\TargetNotMatched::__construct
     */
    public function testGeneratesADefaultMessage()
    {
        $expectedMessage = 'The request target "/" could not be matched';
        $targetNotMatched = new TargetNotMatched('/');

        $actualMessage = $targetNotMatched->getMessage();

        $this->assertEquals($expectedMessage, $actualMessage);
    }

    /**
     * @covers \Meek\Route\TargetNotMatched::__construct
     */
    public function testSetsCodeToHttpNotFound()
    {
        $expectedCode = 404;
        $targetNotMatched = new TargetNotMatched('/');

        $actualCode = $targetNotMatched->getCode();

        $this->assertEquals($expectedCode, $actualCode);
    }

    /**
     * @covers \Meek\Route\TargetNotMatched::getRequestTarget
     */
    public function testCanGetRequestTarget()
    {
        $expectedRequestTarget = '/test/path';
        $targetNotMatched = new TargetNotMatched($expectedRequestTarget);

        $actualRequestTarget = $targetNotMatched->getRequestTarget();

        $this->assertEquals($expectedRequestTarget, $actualRequestTarget);
    }
}
