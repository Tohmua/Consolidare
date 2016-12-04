<?php

use Consolidare\MergePatterns\Exception\FieldMismatchException;
use Consolidare\MergePatterns\Left;
use Consolidare\MergePatterns\MergePattern;
use Consolidare\RecordFields\RecordField;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class LeftTest extends TestCase
{
    public function testItImplementsMergePattern()
    {
        $this->assertTrue(in_array(
            MergePattern::class,
            class_implements(new Left)
        ));
    }

    public function testItReturnsLeftValue()
    {
        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('left');
        $left->value()->willReturn('Foo');
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('left');
        $right->value()->willReturn('Bar');

        $leftPattern = new Left;
        $field = $leftPattern->merge($left->reveal(), $right->reveal());

        $this->assertEquals($left->reveal(), $field);
        $this->assertEquals('Foo', $field->value());
    }

    public function testNewFieldHasSameName()
    {
        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('left');
        $left->value()->willReturn('Foo');
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('left');
        $right->value()->willReturn('Bar');

        $leftPattern = new Left;
        $field = $leftPattern->merge($left->reveal(), $right->reveal());

        $this->assertEquals('left', $field->name());
    }

    public function testItThowsExceptionIfNamesDoNotMatch()
    {
        $this->setExpectedException(FieldMismatchException::class);

        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('a');
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('b');

        $leftPattern = new Left;
        $field = $leftPattern->merge($left->reveal(), $right->reveal());
    }
}
