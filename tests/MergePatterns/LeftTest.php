<?php

use Consolidare\MergePatterns\Left;
use Consolidare\MergePatterns\MergePattern;
use PHPUnit\Framework\TestCase;

class LeftTest extends TestCase
{
    public function testItImplementsMergePattern()
    {
        $this->assertTrue(in_array(
            MergePattern::class,
            class_implements(new Left)
        ));
    }

    public function testItReturnsLeftValue()
    {
        $left = new Left;
        $this->assertEquals("Foo", $left("Foo", "Bar"));
    }
}