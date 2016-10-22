<?php

use PHPUnit\Framework\TestCase;
use Consolidare\Mergable\Type\MergableArray;

class MergableArrayTest extends TestCase
{
    public function testConstructor()
    {
        $mergableArray = new MergableArray(['foo' => 'foo', 'bar' => 'bar']);
        $this->assertTrue(get_class($mergableArray) === MergableArray::class);
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