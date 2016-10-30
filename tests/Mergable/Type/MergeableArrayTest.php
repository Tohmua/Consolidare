<?php

use Consolidare\Mergeable\Mergeable;
use Consolidare\Mergeable\Type\MergeableArray;
use PHPUnit\Framework\TestCase;

class MergeableArrayTest extends TestCase
{
    public function testConstructor()
    {
        $mergeableArray = new MergeableArray(['foo' => 'foo', 'bar' => 'bar']);
        $this->assertTrue(get_class($mergeableArray) === MergeableArray::class);
    }

    public function testItImplementsMergeable()
    {
        $this->assertTrue(in_array(
            Mergeable::class,
            class_implements(new MergeableArray([]))
        ));
    }

    public function testDataCanBeRetrieved()
    {
        $mergeableArray = new MergeableArray(['foo' => 'foo', 'bar' => 'bar']);
        $this->assertEquals(
            ['foo' => 'foo', 'bar' => 'bar'],
            $mergeableArray->retrieve()
        );
    }
}