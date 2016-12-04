<?php

namespace Consolidare\MergePatterns;

use Consolidare\MergePatterns\Exception\FieldMismatchException;
use Consolidare\MergePatterns\MergePattern;
use Consolidare\RecordFields\RecordField;

class Right implements MergePattern
{
    /**
     * Takes two fields and returns the right field
     *
     * @param  RecordField $left
     * @param  RecordField $right
     * @return RecordField
     */
    public function merge(RecordField $left, RecordField $right)
    {
        if ($left->name() !== $right->name()) {
            throw new FieldMismatchException($left, $right);
        }

        return $right;
    }
}
