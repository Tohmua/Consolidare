<?php

use Consolidare\Mergable\Mergable;
use Consolidare\Mergable\Type\MergableArray;
use PHPUnit\Framework\TestCase;

class MergableArrayTest extends TestCase
{
    public function testConstructor()
    {
        $mergableArray = new MergableArray(['foo' => 'foo', 'bar' => 'bar']);
        $this->assertTrue(get_class($mergableArray) === MergableArray::class);
    }

    public function testItImplementsMergable()
    {
        $this->assertTrue(in_array(
            Mergable::class,
            class_implements(new MergableArray([]))
        ));
    }

    public function testDataCanBeRetrieved()
    {
        $mergableArray = new MergableArray(['foo' => 'foo', 'bar' => 'bar']);
        $this->assertEquals(
            ['foo' => 'foo', 'bar' => 'bar'],
            $mergableArray->retrieve()
        );
    }
}