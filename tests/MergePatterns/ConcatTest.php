<?php

use Consolidare\MergePatterns\Concat;
use Consolidare\MergePatterns\MergePattern;
use PHPUnit\Framework\TestCase;

class ConcatTest extends TestCase
{
    public function testItImplementsMergePattern()
    {
        $this->assertTrue(in_array(
            MergePattern::class,
            class_implements(new Concat)
        ));
    }

    public function testItConcatsStrings()
    {
        $concat = new Concat;
        $this->assertEquals("FooBar", $concat("Foo", "Bar"));
    }

    public function testItConcatsIntegers()
    {
        $concat = new Concat;
        $this->assertEquals("1020", $concat(10, 20));
    }

    public function testItConcatsFloats()
    {
        $concat = new Concat;
        $this->assertEquals("10.520.3", $concat(10.5, 20.3));
    }
}