<?php

use PHPUnit\Framework\TestCase;
use Consolidare\Mergeable\Exception\MergeableException;
use Consolidare\Mergeable\Exception\MergeableTypeNotFoundException;
use Consolidare\Mergeable\MergeableFactory;
use Consolidare\Mergeable\Type\MergeableArray;
use Consolidare\Mergeable\Type\MergeableJsonObject;

class MergeableFactoryTest extends TestCase
{
    public function testCreatesMergeableArray()
    {
        $mergeableArray = MergeableFactory::create([]);
        $this->assertTrue(get_class($mergeableArray) === MergeableArray::class);
    }

    public function testCreatesMergeableJsonObject()
    {
        $mergeableJsonObject = MergeableFactory::create('{"foo": "foo"}');
        $this->assertTrue(get_class($mergeableJsonObject) === MergeableJsonObject::class);
    }

    public function testThrowsExceptionIfNoKnownDataType()
    {
        $this->setExpectedException(MergeableTypeNotFoundException::class);
        $mergeableJsonObject = MergeableFactory::create('foo');
    }

    public function testExceptionExtendsParent()
    {
        $this->setExpectedException(MergeableException::class);
        $mergeableJsonObject = MergeableFactory::create('foo');
    }
}