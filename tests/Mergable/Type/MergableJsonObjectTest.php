<?php

use Consolidare\Mergable\Exception\InvalidJsonGivenException;
use Consolidare\Mergable\Type\MergableJsonObject;
use PHPUnit\Framework\TestCase;

class MergableJsonObjectTest extends TestCase
{
    public function testConstructor()
    {
        $mergableJsonObject = new MergableJsonObject('{"foo": "foo", "bar": "bar"}');
        $this->assertTrue(get_class($mergableJsonObject) === MergableJsonObject::class);
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