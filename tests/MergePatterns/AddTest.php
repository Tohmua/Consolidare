<?php

use Consolidare\MergePatterns\Add;
use Consolidare\MergePatterns\Exception\CantAddNonNumericsException;
use Consolidare\MergePatterns\MergePattern;
use PHPUnit\Framework\TestCase;

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
        $add = new Add;
        $this->assertEquals(10, $add(4, 6));
    }

    public function testItAddsNumericStrings()
    {
        $add = new Add;
        $this->assertEquals(26, $add('7', "19"));
    }

    public function testItCantAddStrings()
    {
        $this->setExpectedException(CantAddNonNumericsException::class);
        $add = new Add;
        $add('phil', "jess");
    }

    public function testItCantAddWithLeftStringValue()
    {
        $this->setExpectedException(CantAddNonNumericsException::class);
        $add = new Add;
        $add('phil', 10);
    }

    public function testItCantAddWithRightStringValue()
    {
        $this->setExpectedException(CantAddNonNumericsException::class);
        $add = new Add;
        $add(10, 'jess');
    }
}