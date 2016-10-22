<?php

use PHPUnit\Framework\TestCase;
use Consolidare\Mergable\Type\MergableArray;

class MergableArrayTest extends TestCase
{
    public function testConstructor()
    {
        $mergableArray = new MergableArray(['foo' => 'foo', 'bar' => 'bar']);
        $this->assertTrue();
        // $mergableArray
    }
}