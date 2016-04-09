<?php declare(strict_types=1);

namespace Meek\Route;

use PHPUnit\Framework\TestCase;

class MethodNotMatchedTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testIsARuntimeException()
    {
        $methodNotMatched = new MethodNotMatched('get', []);

        $this->assertInstanceOf('RuntimeException', $methodNotMatched);
    }

    /**
     * @covers \Meek\Route\MethodNotMatched::__construct
     */
    public function testThrowsExceptionIfRequestMethodIsInAllowedMethods()
    {
        $this->expectException('LogicException');
        $this->expectExceptionMessage('The request method is the method that failed the match and should not be in the allowed methods');

        $methodNotMatched = new MethodNotMatched('head', ['head']);
    }

    /**
     * @covers \Meek\Route\MethodNotMatched::__construct
     */
    public function testRequestMethodIsNormalisedToUpperCase()
    {
        $methodNotMatched = new MethodNotMatched('head', []);

        $actualRequestMethod = $methodNotMatched->getRequestMethod();

        $this->assertEquals('HEAD', $actualRequestMethod);
    }

    /**
     * @covers \Meek\Route\MethodNotMatched::__construct
     */
    public function testGeneratesADefaultMessage()
    {
        $expectedMessage = 'The "GET" request method could not be matched';
        $methodNotMatched = new MethodNotMatched('get', []);

        $actualMessage = $methodNotMatched->getMessage();

        $this->assertEquals($expectedMessage, $actualMessage);
    }

    /**
     * @covers \Meek\Route\MethodNotMatched::__construct
     */
    public function testSetsCodeToHttpMethodNotAllowed()
    {
        $expectedCode = 405;
        $methodNotMatched = new MethodNotMatched('get', []);

        $actualCode = $methodNotMatched->getCode();

        $this->assertEquals($expectedCode, $actualCode);
    }

    /**
     * @covers \Meek\Route\MethodNotMatched::__construct
     */
    public function testAllowedMethodsAreNormalizedToUpperCase()
    {
        $methodNotMatched = new MethodNotMatched('get', ['put']);

        $actualAllowedMethods = $methodNotMatched->getAllowedMethods();

        $this->assertEquals(['PUT'], $actualAllowedMethods);
    }

    /**
     * @covers \Meek\Route\MethodNotMatched::getRequestMethod
     */
    public function testCanGetRequestMethod()
    {
        $expectedRequestMethod = 'HEAD';
        $methodNotMatched = new MethodNotMatched($expectedRequestMethod, []);

        $actualRequestMethod = $methodNotMatched->getRequestMethod();

        $this->assertEquals($expectedRequestMethod, $actualRequestMethod);
    }

    /**
     * @covers \Meek\Route\MethodNotMatched::getAllowedMethods
     */
    public function testCanGetAllowedMethods()
    {
        $expectedAllowedMethods = ['PUT'];
        $methodNotMatched = new MethodNotMatched('get', $expectedAllowedMethods);

        $actualAllowedMethods = $methodNotMatched->getAllowedMethods();

        $this->assertEquals($expectedAllowedMethods, $actualAllowedMethods);
    }
}
