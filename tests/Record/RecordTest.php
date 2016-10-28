<?php

use Consolidare\Mergeable\Mergeable;
use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\Record\Exception\PropertyDoesNotExistException;
use Consolidare\Record\Record;
use Consolidare\Record\Records;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class RecordTest extends TestCase
{
    public function testItConstructs()
    {
        $prophet = new Prophet;
        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $record = $prophet->prophesize(Records::class);
        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn([]);

        $this->assertEquals(
            get_class(new Record(
                $mergeStrategy->reveal(),
                $record->reveal(),
                $mergeable->reveal()
            )),
            Record::class
        );
    }

    public function testItImplementsRecordsInterface()
    {
        $prophet = new Prophet;
        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $record = $prophet->prophesize(Records::class);
        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn([]);

        $this->assertTrue(in_array(
            Records::class,
            class_implements(new Record(
                $mergeStrategy->reveal(),
                $record->reveal(),
                $mergeable->reveal()
            ))
        ));
    }

    public function testItsPropertiesCanBeRetrieved()
    {
        $prophet = new Prophet;
        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $record = $prophet->prophesize(Records::class);
        $record->retrieve()->willReturn([]);
        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn([]);

        $record = new Record($mergeStrategy->reveal(), $record->reveal(), $mergeable->reveal());

        $this->assertEquals(
            [],
            $record->retrieve()
        );
    }

    public function testItsPropertiesCanBeRetrievedWithDataInRecord()
    {
        $prophet = new Prophet;
        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $record = $prophet->prophesize(Records::class);
        $record->retrieve()->willReturn(['foo']);
        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn([]);

        $record = new Record($mergeStrategy->reveal(), $record->reveal(), $mergeable->reveal());

        $this->assertEquals(
            ['foo'],
            $record->retrieve()
        );
    }

    public function testItsPropertiesCanBeRetrievedWithDataInMergeable()
    {
        $prophet = new Prophet;
        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $record = $prophet->prophesize(Records::class);
        $record->retrieve()->willReturn([]);
        $record->property(0)->willThrow(PropertyDoesNotExistException::class);
        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn(['bar']);

        $record = new Record($mergeStrategy->reveal(), $record->reveal(), $mergeable->reveal());

        $this->assertEquals(
            ['bar'],
            $record->retrieve()
        );
    }

    public function testItMergesProperties()
    {
        $prophet = new Prophet;
        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $record = $prophet->prophesize(Records::class);
        $record->retrieve()->willReturn(['foo' => 'foo']);
        $record->property('bar')->willThrow(PropertyDoesNotExistException::class);
        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn(['bar' => 'bar']);

        $record = new Record($mergeStrategy->reveal(), $record->reveal(), $mergeable->reveal());

        $this->assertEquals(
            ['foo' => 'foo', 'bar' => 'bar'],
            $record->retrieve()
        );
    }

    public function testItsIndividualPropertiesCanBeAccessed()
    {
        $prophet = new Prophet;
        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $record = $prophet->prophesize(Records::class);
        $record->retrieve()->willReturn(['foo' => 'foo']);
        $record->property('bar')->willThrow(PropertyDoesNotExistException::class);
        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn(['bar' => 'bar']);

        $record = new Record($mergeStrategy->reveal(), $record->reveal(), $mergeable->reveal());

        $this->assertEquals(
            'foo',
            $record->property('foo')
        );
    }

    public function testItsDefersTheMergeDetailsToTheMergeStrategy()
    {
        $prophet = new Prophet;
        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $mergeStrategy->merge('bar', 'bar', 'bar')->willReturn('sheep');
        $record = $prophet->prophesize(Records::class);
        $record->retrieve()->willReturn(['foo' => 'foo']);
        $record->property('bar')->willReturn('bar');
        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn(['bar' => 'bar']);

        $record = new Record($mergeStrategy->reveal(), $record->reveal(), $mergeable->reveal());

        $this->assertEquals(
            'sheep',
            $record->property('bar')
        );
    }

    public function testItRevertsAndReturnsAnInstanceOfAPreviousRecord()
    {
        $prophet = new Prophet;
        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $mergeStrategy->merge('bar', 'bar', 'bar')->willReturn('sheep');
        $record = $prophet->prophesize(Records::class);
        $record->retrieve()->willReturn(['foo' => 'foo']);
        $record->property('bar')->willReturn('bar');
        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn(['bar' => 'bar']);

        $record = new Record($mergeStrategy->reveal(), $record->reveal(), $mergeable->reveal());
        $revert = $record->revert();

        $this->assertTrue(in_array(
            Records::class,
            class_implements($revert)
        ));
    }

    public function testItRevertsAndReturnsThePreviousRecordWithCorrectData()
    {
        $prophet = new Prophet;
        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $mergeStrategy->merge('bar', 'bar', 'bar')->willReturn('sheep');
        $record = $prophet->prophesize(Records::class);
        $record->retrieve()->willReturn(['foo' => 'foo']);
        $record->property('bar')->willReturn('bar');
        $mergeable = $prophet->prophesize(Mergeable::class);
        $mergeable->retrieve()->willReturn(['bar' => 'bar']);

        $record = new Record($mergeStrategy->reveal(), $record->reveal(), $mergeable->reveal());
        $revert = $record->revert();

        $this->assertEquals(
            'bar',
            $revert->property('bar')
        );
    }
}