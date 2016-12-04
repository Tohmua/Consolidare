<?php

use Consolidare\Mergeable\Mergeable;
use Consolidare\Mergeable\Type\MergeableArray;
use Consolidare\RecordFields\RecordField;
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
        $this->assertEquals(2, count($mergeableArray->retrieve()));
    }

    public function testCorrectKeysExsist()
    {
        $mergeableArray = new MergeableArray(['foo' => 'foo', 'bar' => 'bar']);
        $this->assertTrue(array_key_exists('foo', $mergeableArray->retrieve()));
        $this->assertTrue(array_key_exists('bar', $mergeableArray->retrieve()));
    }

    public function testValueCanBeRetrieved()
    {
        $mergeableArray = new MergeableArray(['foo' => 'foo', 'bar' => 'bar']);
        $fields = $mergeableArray->retrieve();
        $this->assertEquals('foo', $fields['foo']->value());
        $this->assertEquals('bar', $fields['bar']->value());
    }

    public function testFieldsHaveBeenCreatedCorrectly()
    {
        $mergeableArray = new MergeableArray(['foo' => 'foo', 'bar' => 'bar']);
        $fields = $mergeableArray->retrieve();
        $this->assertTrue($fields['foo'] instanceof RecordField);
        $this->assertTrue($fields['bar'] instanceof RecordField);
    }
}
