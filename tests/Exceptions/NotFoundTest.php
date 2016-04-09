<?php

namespace Meek\Routing\Tests\Exceptions;

use PHPUnit_Framework_TestCase;
use Meek\Routing\Exceptions\NotFound as NotFoundException;

class NotFoundTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->exception = new NotFoundException();
    }

    public function testExtendsBaseClass()
    {
        $this->assertInstanceOf('Meek\Routing\HttpException', $this->exception);
    }

    public function testHasCorrectCode()
    {
        $this->assertSame(404, $this->exception->getCode());
    }

    public function testHasCorrectMessage()
    {
        $this->assertSame('Not Found', $this->exception->getMessage());
    }
}
