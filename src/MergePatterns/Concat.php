<?php

namespace Consolidare\MergePatterns;

use Consolidare\MergePatterns\Exception\FieldMismatchException;
use Consolidare\MergePatterns\MergePattern;
use Consolidare\RecordFields\Field;
use Consolidare\RecordFields\RecordField;

class Concat implements MergePattern
{
    /**
     * Takes two fields and returns the two values concatenated together as a new field
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

        return new Field(
            $left->name(),
            sprintf("%s%s", $left->value(), $right->value())
        );
    }
}
