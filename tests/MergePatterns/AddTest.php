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
        $this->assertEquals(10, (new Add)(4, 6));
    }

    public function testItAddsNumericStrings()
    {
        $this->assertEquals(26, (new Add)('7', "19"));
    }

    public function testItCantAddStrings()
    {
        $this->setExpectedException(CantAddNonNumericsException::class);
        (new Add)('phil', "jess");
    }

    public function testItCantAddWithLeftStringValue()
    {
        $this->setExpectedException(CantAddNonNumericsException::class);
        (new Add)('phil', 10);
    }

    public function testItCantAddWithRightStringValue()
    {
        $this->setExpectedException(CantAddNonNumericsException::class);
        (new Add)(10, 'jess');
    }
}