<?php

use Consolidare\Merge;
use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\MergeStrategy\MergeStrategyFactory;
use Consolidare\RecordFields\RecordField;
use Consolidare\Record\Record;
use Consolidare\ReturnType\Type\ToArray;
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

        $this->assertEquals(2, count($record->retrieve()));

        $record = $record->retrieve();

        $this->assertEquals('foo', $record['name']->value());
        $this->assertTrue($record['name'] instanceof RecordField);
        $this->assertEquals('name', $record['name']->name());

        $this->assertEquals('foo', $record['email']->value());
        $this->assertTrue($record['email'] instanceof RecordField);
        $this->assertEquals('email', $record['email']->name());
    }

    public function testItMergesWhenGivenAMultipleValuesFromArray()
    {
        $merge = new Merge([]);
        $merge->data(['name' => 'foo', 'email' => 'foo'])
              ->data(['name' => 'bar', 'email' => 'bar'])
              ->data(['name' => 'baz', 'email' => 'baz']);
        $record = $merge->merge(MergeStrategyFactory::basic());

        $this->assertEquals(2, count($record->retrieve()));

        $record = $record->retrieve();

        $this->assertEquals('baz', $record['name']->value());
        $this->assertTrue($record['name'] instanceof RecordField);
        $this->assertEquals('name', $record['name']->name());

        $this->assertEquals('baz', $record['email']->value());
        $this->assertTrue($record['email'] instanceof RecordField);
        $this->assertEquals('email', $record['email']->name());
    }

    public function testItKeepsAllValuesWhenGivenAMultipleValuesFromArray()
    {
        $merge = new Merge([]);
        $merge->data(['name' => 'foo', 'email' => 'foo', 'surname' => 'foo'])
              ->data(['name' => 'bar'])
              ->data(['name' => 'baz', 'email' => 'baz', 'address' => 'baz']);
        $record = $merge->merge(MergeStrategyFactory::basic());

        $this->assertEquals(4, count($record->retrieve()));

        $record = $record->retrieve();

        $this->assertEquals('baz', $record['name']->value());
        $this->assertTrue($record['name'] instanceof RecordField);
        $this->assertEquals('name', $record['name']->name());

        $this->assertEquals('baz', $record['email']->value());
        $this->assertTrue($record['email'] instanceof RecordField);
        $this->assertEquals('email', $record['email']->name());

        $this->assertEquals('foo', $record['surname']->value());
        $this->assertTrue($record['surname'] instanceof RecordField);
        $this->assertEquals('surname', $record['surname']->name());

        $this->assertEquals('baz', $record['address']->value());
        $this->assertTrue($record['address'] instanceof RecordField);
        $this->assertEquals('address', $record['address']->name());
    }

    public function testItMergesWhenGivenAMultipleValuesFromMultipleDataTypes()
    {
        $merge = new Merge([]);
        $merge->data(['name' => 'foo', 'email' => 'foo'])
              ->data('{"name": "bar", "address": "bar"}');
        $record = $merge->merge(MergeStrategyFactory::basic());

        $this->assertEquals(3, count($record->retrieve()));

        $record = $record->retrieve();

        $this->assertEquals('bar', $record['name']->value());
        $this->assertTrue($record['name'] instanceof RecordField);
        $this->assertEquals('name', $record['name']->name());

        $this->assertEquals('foo', $record['email']->value());
        $this->assertTrue($record['email'] instanceof RecordField);
        $this->assertEquals('email', $record['email']->name());

        $this->assertEquals('bar', $record['address']->value());
        $this->assertTrue($record['address'] instanceof RecordField);
        $this->assertEquals('address', $record['address']->name());
    }

    public function testItKeepsRevertsAMerge()
    {
        $merge = new Merge([]);
        $merge->data(['name' => 'foo', 'email' => 'foo', 'surname' => 'foo'])
              ->data(['name' => 'bar'])
              ->data(['name' => 'baz', 'email' => 'baz', 'address' => 'baz']);
        $record = $merge->merge(MergeStrategyFactory::basic());
        $record = $record->revert();

        $this->assertEquals(3, count($record->retrieve()));

        $record = $record->retrieve();

        $this->assertEquals('bar', $record['name']->value());
        $this->assertTrue($record['name'] instanceof RecordField);
        $this->assertEquals('name', $record['name']->name());

        $this->assertEquals('foo', $record['email']->value());
        $this->assertTrue($record['email'] instanceof RecordField);
        $this->assertEquals('email', $record['email']->name());

        $this->assertEquals('foo', $record['surname']->value());
        $this->assertTrue($record['surname'] instanceof RecordField);
        $this->assertEquals('surname', $record['surname']->name());
    }

    public function testItChangesTheReturnTypeWhenAsked()
    {
        $merge = new Merge([]);
        $merge->data(['name' => 'foo', 'email' => 'foo', 'surname' => 'foo'])
              ->data(['name' => 'bar'])
              ->data(['email' => 'baz', 'address' => 'baz']);
        $record = $merge->merge(MergeStrategyFactory::basic());

        $this->assertEquals(4, count($record->retrieve()));

        $array = $record->retrieve(new ToArray);

        $this->assertEquals([
            'name' => 'bar',
            'email' => 'baz',
            'surname' => 'foo',
            'address' => 'baz',
        ], $array);
    }
}
