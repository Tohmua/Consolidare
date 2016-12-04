<?php

use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\Mergeable\Mergeable;
use Consolidare\RecordFields\RecordField;
use Consolidare\Record\Exception\PropertyDoesNotExistException;
use Consolidare\Record\Exception\RecordException;
use Consolidare\Record\Record;
use Consolidare\Record\Records;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophet;

class RecordTest extends TestCase
{
    public function testItConstructs()
    {
        $prophet = new Prophet;

        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);

        $record = $prophet->prophesize(Records::class);

        $this->assertEquals(
            get_class(new Record(
                $mergeStrategy->reveal(),
                $record->reveal()
            )),
            Record::class
        );
    }

    public function testItImplementsRecordsInterface()
    {
        $prophet = new Prophet;

        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);

        $record = $prophet->prophesize(Records::class);

        $this->assertTrue(in_array(
            Records::class,
            class_implements(new Record(
                $mergeStrategy->reveal(),
                $record->reveal()
            ))
        ));
    }

    public function testItsUnMergedPropertiesCanBeRetrieved()
    {
        $prophet = new Prophet;

        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);

        $record = $prophet->prophesize(Records::class);
        $record->retrieve()->willReturn([]);

        $record = new Record($mergeStrategy->reveal(), $record->reveal());

        $this->assertEquals(
            [],
            $record->retrieve()
        );
    }

    public function testItsUnMergedPropertiesCanBeRetrievedWithDataInRecord()
    {
        $prophet = new Prophet;

        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);

        $record = $prophet->prophesize(Records::class);
        $record->retrieve()->willReturn(['foo' => 'bar']);

        $record = new Record($mergeStrategy->reveal(), $record->reveal());

        $this->assertEquals(
            ['foo' => 'bar'],
            $record->retrieve()
        );
    }

    public function testItsMergedPropertiesCanBeRetrievedWithDataInRecordAndBlankMerge()
    {
        $prophet = new Prophet;

        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);

        $record = $prophet->prophesize(Records::class);
        $record->retrieve()->willReturn(['foo' => 'bar']);

        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn([]);

        $record = new Record($mergeStrategy->reveal(), $record->reveal());
        $record->merge($mergeable->reveal());

        $this->assertEquals(
            ['foo' => 'bar'],
            $record->retrieve()
        );
    }

    public function testItsPropertiesCanBeRetrievedWithDataInRecordAndMergeable()
    {
        $prophet = new Prophet;

        $field1 = $prophet->prophesize(RecordField::class);
        $field1->name()->willReturn('foo');
        $field1->value()->willReturn('bar');

        $field2 = $prophet->prophesize(RecordField::class);
        $field2->name()->willReturn('bar');
        $field2->value()->willReturn('baz');

        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);

        $previousRecord = $prophet->prophesize(Records::class);
        $previousRecord->retrieve()->willReturn(['foo' => $field1->reveal()]);
        $previousRecord->field($field2->reveal())->willThrow(PropertyDoesNotExistException::class);

        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn(['bar' => $field2->reveal()]);

        $record = new Record($mergeStrategy->reveal(), $previousRecord->reveal());
        $record->merge($mergeable->reveal());

        $this->assertEquals(
            [
                'foo' => $field1->reveal(),
                'bar' => $field2->reveal(),
            ],
            $record->retrieve()
        );
    }

    public function testItsIndividualPropertiesCanBeAccessedBeforeMerge()
    {
        $prophet = new Prophet;

        $field1 = $prophet->prophesize(RecordField::class);
        $field1->name()->willReturn('foo');
        $field1->value()->willReturn('bar');

        $fieldName = $prophet->prophesize(RecordField::class);
        $fieldName->name()->willReturn('foo');

        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);

        $previousRecord = $prophet->prophesize(Records::class);
        $previousRecord->retrieve()->willReturn(['foo' => $field1->reveal()]);

        $record = new Record($mergeStrategy->reveal(), $previousRecord->reveal());

        $this->assertEquals($field1->reveal(), $record->field($fieldName->reveal()));
    }

    public function testItsIndividualPropertiesCanBeAccessedAfterMerge()
    {
        $prophet = new Prophet;

        $field1 = $prophet->prophesize(RecordField::class);
        $field1->name()->willReturn('foo');
        $field1->value()->willReturn('bar');

        $field2 = $prophet->prophesize(RecordField::class);
        $field2->name()->willReturn('bar');
        $field2->value()->willReturn('baz');

        $fieldName = $prophet->prophesize(RecordField::class);
        $fieldName->name()->willReturn('bar');

        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);

        $previousRecord = $prophet->prophesize(Records::class);
        $previousRecord->retrieve()->willReturn(['foo' => $field1->reveal()]);
        $previousRecord->field($field2->reveal())->willThrow(PropertyDoesNotExistException::class);

        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn(['bar' => $field2->reveal()]);

        $record = new Record($mergeStrategy->reveal(), $previousRecord->reveal());
        $record->merge($mergeable->reveal());

        $this->assertEquals($field2->reveal(), $record->field($fieldName->reveal()));
    }

    public function testItsDefersTheMergeDetailsToTheMergeStrategy()
    {
        $prophet = new Prophet;

        $field1 = $prophet->prophesize(RecordField::class);
        $field1->name()->willReturn('foo');
        $field1->value()->willReturn('bar');

        $field2 = $prophet->prophesize(RecordField::class);
        $field2->name()->willReturn('foo');
        $field2->value()->willReturn('baz');

        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $mergeStrategy->merge($field1->reveal(), $field2->reveal())->willReturn($field2->reveal());

        $previousRecord = $prophet->prophesize(Records::class);
        $previousRecord->retrieve()->willReturn(['foo' => $field1->reveal()]);
        $previousRecord->field($field2->reveal())->willReturn($field1->reveal());

        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn(['foo' => $field2->reveal()]);

        $record = new Record($mergeStrategy->reveal(), $previousRecord->reveal());
        $record->merge($mergeable->reveal());

        $this->assertEquals(['foo' => $field2->reveal()], $record->retrieve());
    }

    public function testTheArrayKeysDoNotReallyMatterIfTheFieldsAreTheSame()
    {
        $prophet = new Prophet;

        $field1 = $prophet->prophesize(RecordField::class);
        $field1->name()->willReturn('foo');
        $field1->value()->willReturn('bar');

        $field2 = $prophet->prophesize(RecordField::class);
        $field2->name()->willReturn('foo');
        $field2->value()->willReturn('baz');

        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $mergeStrategy->merge($field1->reveal(), $field2->reveal())->willReturn($field2->reveal());

        $previousRecord = $prophet->prophesize(Records::class);
        $previousRecord->retrieve()->willReturn(['foo' => $field1->reveal()]);
        $previousRecord->field($field2->reveal())->willReturn($field1->reveal());

        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn(['b' => $field2->reveal()]);

        $record = new Record($mergeStrategy->reveal(), $previousRecord->reveal());
        $record->merge($mergeable->reveal());

        $this->assertEquals(['foo' => $field2->reveal()], $record->retrieve());
    }

    public function testItRevertsAndReturnsAnInstanceOfAPreviousRecord()
    {
        $prophet = new Prophet;

        $field1 = $prophet->prophesize(RecordField::class);
        $field1->name()->willReturn('foo');
        $field1->value()->willReturn('bar');

        $field2 = $prophet->prophesize(RecordField::class);
        $field2->name()->willReturn('foo');
        $field2->value()->willReturn('baz');

        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $mergeStrategy->merge($field1->reveal(), $field2->reveal())->willReturn($field2->reveal());

        $previousRecord = $prophet->prophesize(Records::class);
        $previousRecord->retrieve()->willReturn(['foo' => $field1->reveal()]);
        $previousRecord->field($field2->reveal())->willReturn($field1->reveal());

        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn(['foo' => $field2->reveal()]);

        $record = new Record($mergeStrategy->reveal(), $previousRecord->reveal());
        $record->merge($mergeable->reveal());
        $previous = $record->revert();

        $this->assertTrue($previous instanceof Records);
    }

    public function testItRevertsAndReturnsThePreviousRecordWithCorrectData()
    {
        $prophet = new Prophet;

        $field1 = $prophet->prophesize(RecordField::class);
        $field1->name()->willReturn('foo');
        $field1->value()->willReturn('bar');

        $field2 = $prophet->prophesize(RecordField::class);
        $field2->name()->willReturn('foo');
        $field2->value()->willReturn('baz');

        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $mergeStrategy->merge($field1->reveal(), $field2->reveal())->willReturn($field2->reveal());

        $previousRecord = $prophet->prophesize(Records::class);
        $previousRecord->retrieve()->willReturn(['foo' => $field1->reveal()]);
        $previousRecord->field($field2->reveal())->willReturn($field1->reveal());

        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn(['foo' => $field2->reveal()]);

        $record = new Record($mergeStrategy->reveal(), $previousRecord->reveal());
        $record->merge($mergeable->reveal());
        $previous = $record->revert();

        $this->assertEquals($field1->reveal(), $previous->field($field2->reveal()));
    }
}
