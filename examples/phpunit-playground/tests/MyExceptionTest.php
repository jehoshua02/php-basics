<?php
use PHPUnit\Framework\TestCase;

class MyExceptionTest extends TestCase
{
    public function testException()
    {
        // arrange
        $this->expectException(InvalidArgumentException::class);

        // act
        $instance = new MyClass;
        $instance->doSomething();
    }
}

class MyClass
{
    public function doSomething()
    {
        throw new InvalidArgumentException();
    }
}
