<?php

namespace Meek\Routing\Tests\Exceptions;

use PHPUnit_Framework_TestCase;
use Meek\Routing\Exceptions\MethodNotAllowed as MethodNotAllowedException;

class MethodNotAllowedTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->exception = new MethodNotAllowedException();
    }

    public function testExtendsBaseClass()
    {
        $this->assertInstanceOf('Meek\Routing\HttpException', $this->exception);
    }

    public function testHasCorrectCode()
    {
        $this->assertSame(405, $this->exception->getCode());
    }

    public function testHasCorrectMessage()
    {
        $this->assertSame('Method Not Allowed', $this->exception->getMessage());
    }
}
