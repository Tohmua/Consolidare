<?php

use PHPUnit\Framework\TestCase;
use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\Merge;
use Consolidare\Record\Record;

class MergeTest extends TestCase
{
    public function testConstructor()
    {
        $Merge = new Merge([]);
        $this->assertTrue(get_class($Merge) === Merge::class);
    }

    public function testItReturnsNothingWhenGivenNoData()
    {
        $Merge = new Merge([]);
        $record = $Merge->merge();

        $this->assertNull($record);
    }

    public function testItReturnsARecordWhenGivenASingleValueFromArray()
    {
        $Merge = new Merge([]);
        $Merge->addData(['name' => 'foo', 'email' => 'foo']);
        $record = $Merge->merge();

        $this->assertTrue(get_class($record) === Record::class);
    }

    public function testItMergesWhenGivenASingleValueFromArray()
    {
        $Merge = new Merge([]);
        $Merge->addData(['name' => 'foo', 'email' => 'foo']);
        $record = $Merge->merge();

        $this->assertEquals(['name' => 'foo', 'email' => 'foo'], $record->retrieve());
    }

    public function testItMergesWhenGivenAMultipleValuesFromArray()
    {
        $Merge = new Merge([]);
        $Merge->addData(['name' => 'foo', 'email' => 'foo'])
                    ->addData(['name' => 'bar', 'email' => 'bar'])
                    ->addData(['name' => 'baz', 'email' => 'baz']);
        $record = $Merge->merge();

        $this->assertEquals(['name' => 'baz', 'email' => 'baz'], $record->retrieve());
    }

    public function testItKeepsAllValuesWhenGivenAMultipleValuesFromArray()
    {
        $Merge = new Merge([]);
        $Merge->addData(['name' => 'foo', 'email' => 'foo', 'surname' => 'foo'])
                    ->addData(['name' => 'bar'])
                    ->addData(['name' => 'baz', 'email' => 'baz', 'address' => 'baz']);
        $record = $Merge->merge();

        $this->assertEquals(['name' => 'baz', 'email' => 'baz', 'surname' => 'foo', 'address' => 'baz'], $record->retrieve());
    }


    public function testItMergesWhenGivenAMultipleValuesFromMultipleDataTypes()
    {
        $Merge = new Merge([]);
        $Merge->addData(['name' => 'foo', 'email' => 'foo'])
                    ->addData('{"name": "bar", "address": "bar"}');
        $record = $Merge->merge();

        $this->assertEquals(['name' => 'bar', 'email' => 'foo', 'address' => 'bar'], $record->retrieve());
    }


    public function testItKeepsRevertsAMerge()
    {
        $Merge = new Merge([]);
        $Merge->addData(['name' => 'foo', 'email' => 'foo', 'surname' => 'foo'])
                    ->addData(['name' => 'bar'])
                    ->addData(['name' => 'baz', 'email' => 'baz', 'address' => 'baz']);
        $record = $Merge->merge();
        $record = $record->revert();

        $this->assertEquals(['name' => 'bar', 'email' => 'foo', 'surname' => 'foo'], $record->retrieve());
    }
}
