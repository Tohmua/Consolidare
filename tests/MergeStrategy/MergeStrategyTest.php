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
        $prophet = new Prophet();
        $mergePattern = $prophet->prophesize(MergePattern::class);
        $mergeStrategy = new MergeStrategy($mergePattern->reveal());
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
        $prophet = new Prophet();
        $mergePattern = $prophet->prophesize(MergePattern::class);
        $mergePattern->__invoke('foo', 'bar')->willReturn('bar');

        $mergeStrategy = new MergeStrategy($mergePattern->reveal());
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

        $mergePatternOld = $prophet->prophesize(MergePattern::class);
        $mergePatternOld->__invoke('foo', 'bar')->willReturn('Tom');

        $mergePatternNew = $prophet->prophesize(MergePattern::class);
        $mergePatternNew->__invoke('foo', 'bar')->willReturn('phil');

        $mergeStrategy = new MergeStrategy($mergePatternOld->reveal());
        $mergeStrategy->defaultPattern($mergePatternNew->reveal());

        $this->assertTrue(
            $mergeStrategy->merge('x', 'foo', 'bar') === 'phil'
        );
    }

    public function testYouCanAddAFieldSpecificStrategy()
    {
        $prophet = new Prophet();

        $defaultMergePattern = $prophet->prophesize(MergePattern::class);
        $mergePattern = $prophet->prophesize(MergePattern::class);
        $recordField = $prophet->prophesize(RecordField::class);

        $mergeStrategy = new MergeStrategy($defaultMergePattern->reveal());
        $mergeStrategy->specific(
            $recordField->reveal(),
            $mergePattern->reveal()
        );

        $this->assertTrue(get_class($mergeStrategy) === MergeStrategy::class);
    }

    public function testTheFieldSpecificStrategyIsNotUsedForOtherFields()
    {
        $prophet = new Prophet();

        $defaultMergePattern = $prophet->prophesize(MergePattern::class);
        $defaultMergePattern->__invoke('foo', 'bar')->willReturn('bar');

        $mergePattern = $prophet->prophesize(MergePattern::class);
        $mergePattern->__invoke('foo', 'bar')->willReturn('phil');

        $recordField = $prophet->prophesize(RecordField::class);
        $recordField->name()->willReturn('yyz');

        $mergeStrategy = new MergeStrategy($defaultMergePattern->reveal());
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

        $defaultMergePattern = $prophet->prophesize(MergePattern::class);

        $mergePattern = $prophet->prophesize(MergePattern::class);
        $mergePattern->__invoke('foo', 'bar')->willReturn('phil');

        $recordField = $prophet->prophesize(RecordField::class);
        $recordField->name()->willReturn('yyz');

        $mergeStrategy = new MergeStrategy($defaultMergePattern->reveal());
        $mergeStrategy->specific(
            $recordField->reveal(),
            $mergePattern->reveal()
        );

        $this->assertTrue(
            $mergeStrategy->merge('yyz', 'foo', 'bar') === 'phil'
        );
    }
}
