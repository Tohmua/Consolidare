<?php

use Consolidare\Mergable\Mergable;
use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\Record\Record;
use Consolidare\Record\RecordFactory;
use Consolidare\Record\Records;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class RecordFactoryTest extends TestCase
{
    public function testCreateRecordWithNoPreviousRecord()
    {
        $prophet = new Prophet;
        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $mergable = $prophet->prophesize(Mergable::class);
        $mergable->retrieve()->willReturn([]);

        $this->assertEquals(
            get_class(RecordFactory::create(
                $mergeStrategy->reveal(),
                NULL,
                $mergable->reveal()
            )),
            Record::class
        );
    }

    public function testCreateRecordWithPreviousRecord()
    {
        $prophet = new Prophet;
        $mergeStrategy = $prophet->prophesize(MergeStrategy::class);
        $record = $prophet->prophesize(Records::class);
        $mergable = $prophet->prophesize(Mergable::class);
        $mergable->retrieve()->willReturn([]);

        $this->assertEquals(
            get_class(RecordFactory::create(
                $mergeStrategy->reveal(),
                $record->reveal(),
                $mergable->reveal()
            )),
            Record::class
        );
    }
}