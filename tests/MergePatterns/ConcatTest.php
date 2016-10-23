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
        $this->assertEquals("FooBar", (new Concat)("Foo", "Bar"));
    }

    public function testItConcatsIntegers()
    {
        $this->assertEquals("1020", (new Concat)(10, 20));
    }

    public function testItConcatsFloats()
    {
        $this->assertEquals("10.520.3", (new Concat)(10.5, 20.3));
    }
}