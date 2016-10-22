<?php

use PHPUnit\Framework\TestCase;
use RecordMerge\Mergable\Exception\MergableException;
use RecordMerge\Mergable\Exception\MergableTypeNotFoundException;
use RecordMerge\Mergable\MergableFactory;
use RecordMerge\Mergable\Type\MergableArray;
use RecordMerge\Mergable\Type\MergableJsonObject;

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