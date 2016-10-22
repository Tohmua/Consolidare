<?php

use PHPUnit\Framework\TestCase;
use Consolidare\Mergable\Exception\MergableException;
use Consolidare\Mergable\Exception\MergableTypeNotFoundException;
use Consolidare\Mergable\MergableFactory;
use Consolidare\Mergable\Type\MergableArray;
use Consolidare\Mergable\Type\MergableJsonObject;

class MergableFactoryTest extends TestCase
{
    public function testCreatesMergableArray()
    {
        $mergableArray = MergableFactory::create([]);
        $this->assertTrue(get_class($mergableArray) === MergableArray::class);
    }

    public function testCreatesMergableJsonObject()
    {
        $mergableJsonObject = MergableFactory::create('{"foo": "foo"}');
        $this->assertTrue(get_class($mergableJsonObject) === MergableJsonObject::class);
    }

    public function testThrowsExceptionIfNoKnownDataType()
    {
        $this->setExpectedException(MergableTypeNotFoundException::class);
        $mergableJsonObject = MergableFactory::create('foo');
    }

    public function testExceptionExtendsParent()
    {
        $this->setExpectedException(MergableException::class);
        $mergableJsonObject = MergableFactory::create('foo');
    }
}