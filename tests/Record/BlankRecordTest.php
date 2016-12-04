<?php

use Consolidare\RecordFields\RecordField;
use Consolidare\Record\BlankRecord;
use Consolidare\Record\Exception\CantRevertBackFurtherException;
use Consolidare\Record\Exception\PropertyDoesNotExistException;
use Consolidare\Record\Records;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class BlankRecordTest extends TestCase
{
    public function testItImplementsRecordsInterface()
    {
        $this->assertTrue(in_array(
            Records::class,
            class_implements(new BlankRecord)
        ));
    }

    public function testRetrieveReturnsBlankArray()
    {
        $this->assertEquals(
            [],
            (new BlankRecord)->retrieve()
        );
    }

    public function testPropertyThrowsException()
    {
        $this->setExpectedException(PropertyDoesNotExistException::class);

        $prophet = new Prophet;
        $record = $prophet->prophesize(RecordField::class);
        $record->name()->willReturn('foo');

        (new BlankRecord)->field($record->reveal());
    }

    public function testRevertThrowsException()
    {
        $this->setExpectedException(CantRevertBackFurtherException::class);
        (new BlankRecord)->revert();
    }
}
