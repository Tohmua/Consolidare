<?php

use Consolidare\RecordFields\RecordField;
use Consolidare\Record\Records;
use Consolidare\ReturnType\ReturnType;
use Consolidare\ReturnType\Type\ToArray;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class ToArrayTest extends TestCase
{
    public function testItConstructs()
    {
        $toArray = new ToArray;
        $this->assertTrue($toArray instanceof ToArray);
    }

    public function testItImplementsReturnTypeInterface()
    {
        $toArray = new ToArray;
        $this->assertTrue(
            in_array(
                ReturnType::class,
                class_implements($toArray)
            )
        );
    }

    public function testItConvertsToArray()
    {
        $prophet = new Prophet;

        $field1 = $prophet->prophesize(RecordField::class);
        $field1->value()->willReturn('a');
        $field2 = $prophet->prophesize(RecordField::class);
        $field2->value()->willReturn('b');

        $record = $prophet->prophesize(Records::class);
        $record->retrieve()->willReturn([
            'field_1' => $field1->reveal(),
            'field_2' => $field2->reveal(),
        ]);

        $toArray = new ToArray;
        $this->assertEquals([
            'field_1' => 'a',
            'field_2' => 'b',
        ], $toArray($record->reveal()));
    }
}
