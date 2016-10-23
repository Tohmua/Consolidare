<?php

use Consolidare\MergePatterns\MergePattern;
use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\RecordFields\RecordField;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class MergeStrategyTest extends TestCase
{
    public function testItConstructs()
    {
        $mergeStrategy = new MergeStrategy;
        $this->assertTrue(get_class($mergeStrategy) === MergeStrategy::class);
    }

    public function testItConstructsWithNoneDefaultMergePattern()
    {
        $prophet = new Prophet();
        $mergePattern = $prophet->prophesize(MergePattern::class);
        $mergeStrategy = new MergeStrategy($mergePattern->reveal());
        $this->assertTrue(get_class($mergeStrategy) === MergeStrategy::class);
    }

    public function testItFollowsDefaultPattern()
    {
        $mergeStrategy = new MergeStrategy;
        $this->assertTrue(
            $mergeStrategy->merge('x', 'foo', 'bar') === 'bar'
        );
    }

    public function testItFollowsNonDefaultPattern()
    {
        $prophet = new Prophet();

        $mergePattern = $prophet->prophesize(MergePattern::class);
        $mergePattern->__invoke('foo', 'bar')->willReturn('phil');

        $mergeStrategy = new MergeStrategy($mergePattern->reveal());

        $this->assertTrue(
            $mergeStrategy->merge('x', 'foo', 'bar') === 'phil'
        );
    }

    public function testYouCanOverwiteDefailtPatternAfterConstruction()
    {
        $prophet = new Prophet();

        $mergePattern = $prophet->prophesize(MergePattern::class);
        $mergePattern->__invoke('foo', 'bar')->willReturn('phil');

        $mergeStrategy = new MergeStrategy;
        $mergeStrategy->defaultPattern($mergePattern->reveal());

        $this->assertTrue(
            $mergeStrategy->merge('x', 'foo', 'bar') === 'phil'
        );
    }

    public function testYouCanAddAFieldSpecificStrategy()
    {
        $prophet = new Prophet();

        $mergePattern = $prophet->prophesize(MergePattern::class);
        $mergePattern->__invoke('foo', 'bar')->willReturn('phil');

        $recordField = $prophet->prophesize(RecordField::class);
        $recordField->name()->willReturn('yyz');

        $mergeStrategy = new MergeStrategy;
        $mergeStrategy->specific(
            $recordField->reveal(),
            $mergePattern->reveal()
        );

        $this->assertTrue(get_class($mergeStrategy) === MergeStrategy::class);
    }

    public function testTheFieldSpecificStrategyIsNotUsedForOtherFields()
    {
        $prophet = new Prophet();

        $mergePattern = $prophet->prophesize(MergePattern::class);
        $mergePattern->__invoke('foo', 'bar')->willReturn('phil');

        $recordField = $prophet->prophesize(RecordField::class);
        $recordField->name()->willReturn('yyz');

        $mergeStrategy = new MergeStrategy;
        $mergeStrategy->specific(
            $recordField->reveal(),
            $mergePattern->reveal()
        );

        $this->assertTrue(
            $mergeStrategy->merge('x', 'foo', 'bar') === 'bar'
        );
    }

    public function testTheFieldSpecificStrategyIsUsedForItsIntendedField()
    {
        $prophet = new Prophet();

        $mergePattern = $prophet->prophesize(MergePattern::class);
        $mergePattern->__invoke('foo', 'bar')->willReturn('phil');

        $recordField = $prophet->prophesize(RecordField::class);
        $recordField->name()->willReturn('yyz');

        $mergeStrategy = new MergeStrategy;
        $mergeStrategy->specific(
            $recordField->reveal(),
            $mergePattern->reveal()
        );

        $this->assertTrue(
            $mergeStrategy->merge('yyz', 'foo', 'bar') === 'phil'
        );
    }
}