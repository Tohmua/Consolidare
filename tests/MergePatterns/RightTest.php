<?php

use Consolidare\MergePatterns\Exception\FieldMismatchException;
use Consolidare\MergePatterns\MergePattern;
use Consolidare\MergePatterns\Right;
use Consolidare\RecordFields\RecordField;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class RightTest extends TestCase
{
    public function testItImplementsMergePattern()
    {
        $this->assertTrue(in_array(
            MergePattern::class,
            class_implements(new Right)
        ));
    }

    public function testItReturnsRightValue()
    {
        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('right');
        $left->value()->willReturn('Foo');
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('right');
        $right->value()->willReturn('Bar');

        $rightPattern = new Right;
        $field = $rightPattern->merge($left->reveal(), $right->reveal());

        $this->assertEquals($right->reveal(), $field);
        $this->assertEquals('Bar', $field->value());
    }

    public function testNewFieldHasSameName()
    {
        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('right');
        $left->value()->willReturn('Foo');
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('right');
        $right->value()->willReturn('Bar');

        $rightPattern = new Right;
        $field = $rightPattern->merge($left->reveal(), $right->reveal());

        $this->assertEquals('right', $field->name());
    }

    public function testItThowsExceptionIfNamesDoNotMatch()
    {
        $this->setExpectedException(FieldMismatchException::class);

        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('a');
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('b');

        $rightPattern = new Right;
        $field = $rightPattern->merge($left->reveal(), $right->reveal());
    }
}
