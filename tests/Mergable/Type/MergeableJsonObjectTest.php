<?php

use Consolidare\Mergeable\Exception\InvalidJsonGivenException;
use Consolidare\Mergeable\Mergeable;
use Consolidare\Mergeable\Type\MergeableJsonObject;
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
        $this->assertEquals(
            ['foo' => 'foo', 'bar' => 'bar'],
            $mergeableJsonObject->retrieve()
        );
    }

    public function testItThrowsAnExceptionWithInvalidJson()
    {
        $this->setExpectedException(InvalidJsonGivenException::class);
        $mergeableJsonObject = new MergeableJsonObject('{"foo": "foo", "bar": "bar"');
    }
}