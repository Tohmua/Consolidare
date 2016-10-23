<?php

use Consolidare\MergePatterns\Right;
use Consolidare\MergePatterns\MergePattern;
use PHPUnit\Framework\TestCase;

class RightTest extends TestCase
{
    public function testItImplementsMergePattern()
    {
        $this->assertTrue(in_array(
            MergePattern::class,
            class_implements(new Right)
        ));
    }

    public function testItReturnsRightValue()
    {
        $right = new Right;
        $this->assertEquals("Bar", $right("Foo", "Bar"));
    }
}