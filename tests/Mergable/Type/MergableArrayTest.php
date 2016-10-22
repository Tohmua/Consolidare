<?php

use PHPUnit\Framework\TestCase;
use RecordMerge\Mergable\Type\MergableArray;

class MergableArrayTest extends TestCase
{
    public function testConstructor()
    {
        $mergableArray = new MergableArray(['foo' => 'foo', 'bar' => 'bar']);
        $this->assertTrue();
        $mergableArray
    }
}