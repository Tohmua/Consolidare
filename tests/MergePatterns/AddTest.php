<?php

use Consolidare\MergePatterns\Add;
use Consolidare\MergePatterns\Exception\CantAddNonNumericsException;
use Consolidare\MergePatterns\Exception\FieldMismatchException;
use Consolidare\MergePatterns\MergePattern;
use Consolidare\RecordFields\Field;
use Consolidare\RecordFields\RecordField;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class AddTest extends TestCase
{
    public function testItImplementsMergePattern()
    {
        $this->assertTrue(in_array(
            MergePattern::class,
            class_implements(new Add)
        ));
    }

    public function testItAdds()
    {
        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('sum');
        $left->value()->willReturn(4);
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('sum');
        $right->value()->willReturn(6);

        $add = new Add;
        $newField = $add->merge($left->reveal(), $right->reveal());

        $this->assertEquals('sum', $newField->name());
        $this->assertEquals(10, $newField->value());
    }

    public function testNewFieldHasSameName()
    {
        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('sum');
        $left->value()->willReturn(4);
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('sum');
        $right->value()->willReturn(6);

        $add = new Add;
        $newField = $add->merge($left->reveal(), $right->reveal());

        $this->assertEquals('sum', $newField->name());
    }

    public function testItThowsExceptionIfNamesDoNotMatch()
    {
        $this->setExpectedException(FieldMismatchException::class);

        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('a');
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('b');

        $add = new Add;
        $newField = $add->merge($left->reveal(), $right->reveal());
    }

    public function testItAddsNumericStrings()
    {
        $prophet = new Prophet;

        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('sum');
        $left->value()->willReturn(7);
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('sum');
        $right->value()->willReturn(19);

        $add = new Add;
        $newField = $add->merge($left->reveal(), $right->reveal());

        $this->assertEquals('sum', $newField->name());
        $this->assertEquals(26, $newField->value());
    }

    public function testItCantAddWithLeftStringValue()
    {
        $this->setExpectedException(CantAddNonNumericsException::class);

        $prophet = new Prophet;
        $left = $prophet->prophesize(RecordField::class);
        $left->value()->willReturn('phil');
        $left->name()->willReturn('sum');
        $right = $prophet->prophesize(RecordField::class);
        $right->name()->willReturn('sum');

        $add = new Add;
        $add->merge($left->reveal(), $right->reveal());
    }

    public function testItCantAddWithRightStringValue()
    {
        $this->setExpectedException(CantAddNonNumericsException::class);

        $prophet = new Prophet;
        $left = $prophet->prophesize(RecordField::class);
        $left->name()->willReturn('sum');
        $left->value()->willReturn(10);
        $right = $prophet->prophesize(RecordField::class);
        $right->value()->willReturn('jess');
        $right->name()->willReturn('sum');

        $add = new Add;
        $add->merge($left->reveal(), $right->reveal());
    }
}
