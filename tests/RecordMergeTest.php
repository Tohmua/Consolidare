<?php

use PHPUnit\Framework\TestCase;
use RecordMerge\MergeStrategy\MergeStrategy;
use RecordMerge\RecordMerge;
use RecordMerge\Record\Record;

class RecordMergeTest extends TestCase
{
    public function testConstructor()
    {
        $recordMerge = new RecordMerge([]);
        $this->assertTrue(get_class($recordMerge) === RecordMerge::class);
    }

    public function testItReturnsNothingWhenGivenNoData()
    {
        $recordMerge = new RecordMerge([]);
        $record = $recordMerge->merge();

        $this->assertNull($record);
    }

    public function testItReturnsARecordWhenGivenASingleValueFromArray()
    {
        $recordMerge = new RecordMerge([]);
        $recordMerge->addData(['name' => 'foo', 'email' => 'foo']);
        $record = $recordMerge->merge();

        $this->assertTrue(get_class($record) === Record::class);
    }

    public function testItMergesWhenGivenASingleValueFromArray()
    {
        $recordMerge = new RecordMerge([]);
        $recordMerge->addData(['name' => 'foo', 'email' => 'foo']);
        $record = $recordMerge->merge();

        $this->assertEquals(['name' => 'foo', 'email' => 'foo'], $record->retrieve());
    }

    public function testItMergesWhenGivenAMultipleValuesFromArray()
    {
        $recordMerge = new RecordMerge([]);
        $recordMerge->addData(['name' => 'foo', 'email' => 'foo'])
                    ->addData(['name' => 'bar', 'email' => 'bar'])
                    ->addData(['name' => 'baz', 'email' => 'baz']);
        $record = $recordMerge->merge();

        $this->assertEquals(['name' => 'baz', 'email' => 'baz'], $record->retrieve());
    }

    public function testItKeepsAllValuesWhenGivenAMultipleValuesFromArray()
    {
        $recordMerge = new RecordMerge([]);
        $recordMerge->addData(['name' => 'foo', 'email' => 'foo', 'surname' => 'foo'])
                    ->addData(['name' => 'bar'])
                    ->addData(['name' => 'baz', 'email' => 'baz', 'address' => 'baz']);
        $record = $recordMerge->merge();

        $this->assertEquals(['name' => 'baz', 'email' => 'baz', 'surname' => 'foo', 'address' => 'baz'], $record->retrieve());
    }


    public function testItMergesWhenGivenAMultipleValuesFromMultipleDataTypes()
    {
        $recordMerge = new RecordMerge([]);
        $recordMerge->addData(['name' => 'foo', 'email' => 'foo'])
                    ->addData('{"name": "bar", "address": "bar"}');
        $record = $recordMerge->merge();

        $this->assertEquals(['name' => 'bar', 'email' => 'foo', 'address' => 'bar'], $record->retrieve());
    }


    public function testItKeepsRevertsAMerge()
    {
        $recordMerge = new RecordMerge([]);
        $recordMerge->addData(['name' => 'foo', 'email' => 'foo', 'surname' => 'foo'])
                    ->addData(['name' => 'bar'])
                    ->addData(['name' => 'baz', 'email' => 'baz', 'address' => 'baz']);
        $record = $recordMerge->merge();
        $record = $record->revert();

        $this->assertEquals(['name' => 'bar', 'email' => 'foo', 'surname' => 'foo'], $record->retrieve());
    }
}
