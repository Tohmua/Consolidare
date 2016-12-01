<?php

use Consolidare\Merge;
use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\MergeStrategy\MergeStrategyFactory;
use Consolidare\Record\Record;
use PHPUnit\Framework\TestCase;

class MergeTest extends TestCase
{
    public function testConstructor()
    {
        $merge = new Merge([]);
        $this->assertTrue(get_class($merge) === Merge::class);
    }

    public function testItReturnsNothingWhenGivenNoData()
    {
        $merge = new Merge([]);
        $record = $merge->merge(MergeStrategyFactory::basic());

        $this->assertNull($record);
    }

    public function testItReturnsARecordWhenGivenASingleValueFromArray()
    {
        $merge = new Merge([]);
        $merge->data(['name' => 'foo', 'email' => 'foo']);
        $record = $merge->merge(MergeStrategyFactory::basic());

        $this->assertTrue(get_class($record) === Record::class);
    }

    public function testItMergesWhenGivenASingleValueFromArray()
    {
        $merge = new Merge([]);
        $merge->data(['name' => 'foo', 'email' => 'foo']);
        $record = $merge->merge(MergeStrategyFactory::basic());

        $this->assertEquals(['name' => 'foo', 'email' => 'foo'], $record->retrieve());
    }

    public function testItMergesWhenGivenAMultipleValuesFromArray()
    {
        $merge = new Merge([]);
        $merge->data(['name' => 'foo', 'email' => 'foo'])
              ->data(['name' => 'bar', 'email' => 'bar'])
              ->data(['name' => 'baz', 'email' => 'baz']);
        $record = $merge->merge(MergeStrategyFactory::basic());

        $this->assertEquals(['name' => 'baz', 'email' => 'baz'], $record->retrieve());
    }

    public function testItKeepsAllValuesWhenGivenAMultipleValuesFromArray()
    {
        $merge = new Merge([]);
        $merge->data(['name' => 'foo', 'email' => 'foo', 'surname' => 'foo'])
              ->data(['name' => 'bar'])
              ->data(['name' => 'baz', 'email' => 'baz', 'address' => 'baz']);
        $record = $merge->merge(MergeStrategyFactory::basic());

        $this->assertEquals(['name' => 'baz', 'email' => 'baz', 'surname' => 'foo', 'address' => 'baz'], $record->retrieve());
    }


    public function testItMergesWhenGivenAMultipleValuesFromMultipleDataTypes()
    {
        $merge = new Merge([]);
        $merge->data(['name' => 'foo', 'email' => 'foo'])
              ->data('{"name": "bar", "address": "bar"}');
        $record = $merge->merge(MergeStrategyFactory::basic());

        $this->assertEquals(['name' => 'bar', 'email' => 'foo', 'address' => 'bar'], $record->retrieve());
    }


    public function testItKeepsRevertsAMerge()
    {
        $merge = new Merge([]);
        $merge->data(['name' => 'foo', 'email' => 'foo', 'surname' => 'foo'])
              ->data(['name' => 'bar'])
              ->data(['name' => 'baz', 'email' => 'baz', 'address' => 'baz']);
        $record = $merge->merge(MergeStrategyFactory::basic());
        $record = $record->revert();

        $this->assertEquals(['name' => 'bar', 'email' => 'foo', 'surname' => 'foo'], $record->retrieve());
    }
}
