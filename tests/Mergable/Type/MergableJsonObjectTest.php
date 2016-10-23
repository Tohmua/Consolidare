<?php

use Consolidare\Mergable\Exception\InvalidJsonGivenException;
use Consolidare\Mergable\Mergable;
use Consolidare\Mergable\Type\MergableJsonObject;
use PHPUnit\Framework\TestCase;

class MergableJsonObjectTest extends TestCase
{
    public function testConstructor()
    {
        $mergableJsonObject = new MergableJsonObject('{}');
        $this->assertTrue(get_class($mergableJsonObject) === MergableJsonObject::class);
    }

    public function testItImplementsMergable()
    {
        $this->assertTrue(in_array(
            Mergable::class,
            class_implements(new MergableJsonObject('{}'))
        ));
    }

    public function testDataCanBeRetrieved()
    {
        $mergableJsonObject = new MergableJsonObject('{"foo": "foo", "bar": "bar"}');
        $this->assertEquals(
            ['foo' => 'foo', 'bar' => 'bar'],
            $mergableJsonObject->retrieve()
        );
    }

    public function testItThrowsAnExceptionWithInvalidJson()
    {
        $this->setExpectedException(InvalidJsonGivenException::class);
        $mergableJsonObject = new MergableJsonObject('{"foo": "foo", "bar": "bar"');
    }
}