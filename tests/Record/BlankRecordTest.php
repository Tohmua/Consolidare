<?php

use Consolidare\Record\BlankRecord;
use Consolidare\Record\Exception\CantRevertBackFurtherException;
use Consolidare\Record\Exception\PropertyDoesNotExistException;
use Consolidare\Record\Records;
use PHPUnit\Framework\TestCase;

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
        (new BlankRecord)->property('foo');
    }

    public function testRevertThrowsException()
    {
        $this->setExpectedException(CantRevertBackFurtherException::class);
        (new BlankRecord)->revert();
    }
}