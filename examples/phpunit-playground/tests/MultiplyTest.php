<?php
use PHPUnit\Framework\TestCase;

class MultiplyTest extends TestCase
{
    public function testMultiplyFourNine()
    {
        $this->assertSame(36, 4 * 9);
    }

    public function testMultiplyThreeFive()
    {
        $this->assertSame(15, 3 * 5);
    }

    public function testMultiplyEightSeven()
    {
        $this->assertSame(56, 8 * 7);
    }
}