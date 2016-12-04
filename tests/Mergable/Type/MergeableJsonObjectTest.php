<?php

use Consolidare\Mergeable\Exception\InvalidJsonGivenException;
use Consolidare\Mergeable\Mergeable;
use Consolidare\Mergeable\Type\MergeableJsonObject;
use Consolidare\RecordFields\RecordField;
use PHPUnit\Framework\TestCase;

class MergeableJsonObjectTest extends TestCase
{
    public function testConstructor()
    {
        $mergeableJsonObject = new MergeableJsonObject('{}');
        $this->assertTrue(get_class($mergeableJsonObject) === MergeableJsonObject::class);
    }

    public function testItImplementsMergeable()
    {
        $this->assertTrue(in_array(
            Mergeable::class,
            class_implements(new MergeableJsonObject('{}'))
        ));
    }

    public function testDataCanBeRetrieved()
    {
        $mergeableJsonObject = new MergeableJsonObject('{"foo": "foo", "bar": "bar"}');
        $this->assertEquals(2, count($mergeableJsonObject->retrieve()));
    }

    public function testCorrectKeysExsist()
    {
        $mergeableJsonObject = new MergeableJsonObject('{"foo": "foo", "bar": "bar"}');
        $this->assertTrue(array_key_exists('foo', $mergeableJsonObject->retrieve()));
        $this->assertTrue(array_key_exists('bar', $mergeableJsonObject->retrieve()));
    }

    public function testValueCanBeRetrieved()
    {
        $mergeableJsonObject = new MergeableJsonObject('{"foo": "foo", "bar": "bar"}');
        $fields = $mergeableJsonObject->retrieve();
        $this->assertEquals('foo', $fields['foo']->value());
        $this->assertEquals('bar', $fields['bar']->value());
    }

    public function testFieldsHaveBeenCreatedCorrectly()
    {
        $mergeableJsonObject = new MergeableJsonObject('{"foo": "foo", "bar": "bar"}');
        $fields = $mergeableJsonObject->retrieve();
        $this->assertTrue($fields['foo'] instanceof RecordField);
        $this->assertTrue($fields['bar'] instanceof RecordField);
    }

    public function testItThrowsAnExceptionWithInvalidJson()
    {
        $this->setExpectedException(InvalidJsonGivenException::class);
        $mergeableJsonObject = new MergeableJsonObject('{"foo": "foo", "bar": "bar"');
    }
}
