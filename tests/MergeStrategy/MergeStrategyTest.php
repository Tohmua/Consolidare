<?php

use Consolidare\MergePatterns\Exception\FieldMismatchException;
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

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('x');
        $left->value()->willReturn('foo');

        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('x');
        $right->value()->willReturn('bar');

        $mergePattern = $prophet->prophesize(MergePattern::class);
        $mergePattern->merge($left->reveal(), $right->reveal())->willReturn($left->reveal());

        $mergeStrategy = new MergeStrategy($mergePattern->reveal());

        $this->assertEquals(
            $left->reveal(),
            $mergeStrategy->merge($left->reveal(), $right->reveal())
        );
    }

    public function testYouCanOverwiteDefailtPatternAfterConstruction()
    {
        $prophet = new Prophet();

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('x');
        $left->value()->willReturn('foo');

        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('x');
        $right->value()->willReturn('bar');

        $mergePatternOld = $prophet->prophesize(MergePattern::class);

        $mergePatternNew = $prophet->prophesize(MergePattern::class);
        $mergePatternNew->merge($left->reveal(), $right->reveal())->willReturn($right->reveal());

        $mergeStrategy = new MergeStrategy($mergePatternOld->reveal());
        $mergeStrategy->defaultPattern($mergePatternNew->reveal());

        $this->assertEquals(
            $right->reveal(),
            $mergeStrategy->merge($left->reveal(), $right->reveal())
        );
    }

    public function testYouCanAddAFieldSpecificStrategy()
    {
        $prophet = new Prophet();

        $defaultMergePattern = $prophet->prophesize(MergePattern::class);

        $mergePattern = $prophet->prophesize(MergePattern::class);
        $field = $prophet->prophesize(RecordField::class);

        $mergeStrategy = new MergeStrategy($defaultMergePattern->reveal());
        $mergeStrategy->specific(
            $field->reveal(),
            $mergePattern->reveal()
        );

        $this->assertEquals(MergeStrategy::class, get_class($mergeStrategy));
    }

    public function testTheFieldSpecificStrategyIsNotUsedForOtherFields()
    {
        $prophet = new Prophet();

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('x');
        $left->value()->willReturn('foo');

        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('x');
        $right->value()->willReturn('bar');

        $field = $prophet->prophesize(RecordField::class);
        $field->name()->willReturn('xyz');

        $defaultMergePattern = $prophet->prophesize(MergePattern::class);
        $defaultMergePattern->merge($left->reveal(), $right->reveal())->willReturn($left->reveal());

        $mergePattern = $prophet->prophesize(MergePattern::class);

        $mergeStrategy = new MergeStrategy($defaultMergePattern->reveal());
        $mergeStrategy->specific(
            $field->reveal(),
            $mergePattern->reveal()
        );

        $this->assertEquals(
            $left->reveal(),
            $mergeStrategy->merge($left->reveal(), $right->reveal())
        );
    }

    public function testTheFieldSpecificStrategyIsUsedForItsIntendedField()
    {
        $prophet = new Prophet();

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('x');
        $left->value()->willReturn('foo');

        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('x');
        $right->value()->willReturn('bar');

        $field = $prophet->prophesize(RecordField::class);
        $field->name()->willReturn('x');

        $defaultMergePattern = $prophet->prophesize(MergePattern::class);

        $mergePattern = $prophet->prophesize(MergePattern::class);
        $mergePattern->merge($left->reveal(), $right->reveal())->willReturn($left->reveal());

        $mergeStrategy = new MergeStrategy($defaultMergePattern->reveal());
        $mergeStrategy->specific(
            $field->reveal(),
            $mergePattern->reveal()
        );

        $this->assertEquals(
            $left->reveal(),
            $mergeStrategy->merge($left->reveal(), $right->reveal())
        );
    }

    public function testItThrowsAnExceptionIfFieldNamesDoNotMatch()
    {
        $this->setExpectedException(FieldMismatchException::class);

        $prophet = new Prophet();

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('a');

        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('b');

        $mergePattern = $prophet->prophesize(MergePattern::class);

        $mergeStrategy = new MergeStrategy($mergePattern->reveal());

        $mergeStrategy->merge($left->reveal(), $right->reveal());
    }
}
