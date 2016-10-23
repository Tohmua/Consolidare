<?php

use Consolidare\RecordFields\Field;
use Consolidare\RecordFields\RecordField;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{
    public function testItImplementsRecordField()
    {
        $this->assertTrue(in_array(
            RecordField::class,
            class_implements(new Field('foo'))
        ));
    }

    public function testYouCanGetItsName()
    {
        $this->assertEquals(
            'foo',
            (new Field('foo'))->name()
        );
    }
}