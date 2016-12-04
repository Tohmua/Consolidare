<?php

use Consolidare\MergePatterns\Concat;
use Consolidare\MergePatterns\Exception\FieldMismatchException;
use Consolidare\MergePatterns\MergePattern;
use Consolidare\RecordFields\RecordField;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class ConcatTest extends TestCase
{
    public function testItImplementsMergePattern()
    {
        $this->assertTrue(in_array(
            MergePattern::class,
            class_implements(new Concat)
        ));
    }

    public function testItConcatsStrings()
    {
        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('concat');
        $left->value()->willReturn('Foo');
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('concat');
        $right->value()->willReturn('Bar');

        $concat = new Concat;
        $newField = $concat->merge($left->reveal(), $right->reveal());
        $this->assertEquals("FooBar", $newField->value());
    }

    public function testNewFieldHasSameName()
    {
        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('concat');
        $left->value()->willReturn('Foo');
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('concat');
        $right->value()->willReturn('Bar');

        $concat = new Concat;
        $newField = $concat->merge($left->reveal(), $right->reveal());

        $this->assertEquals('concat', $newField->name());
    }

    public function testItThowsExceptionIfNamesDoNotMatch()
    {
        $this->setExpectedException(FieldMismatchException::class);

        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('a');
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('b');

        $concat = new Concat;
        $newField = $concat->merge($left->reveal(), $right->reveal());
    }

    public function testItConcatsIntegers()
    {
        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('concat');
        $left->value()->willReturn(10);
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('concat');
        $right->value()->willReturn(20);

        $concat = new Concat;
        $newField = $concat->merge($left->reveal(), $right->reveal());
        $this->assertEquals("1020", $newField->value());
    }

    public function testItConcatsFloats()
    {
        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('concat');
        $left->value()->willReturn(10.5);
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('concat');
        $right->value()->willReturn(20.3);

        $concat = new Concat;
        $newField = $concat->merge($left->reveal(), $right->reveal());
        $this->assertEquals("10.520.3", $newField->value());
    }
}
