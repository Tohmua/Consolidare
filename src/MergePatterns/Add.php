<?php

namespace Consolidare\MergePatterns;

use Consolidare\MergePatterns\Exception\CantAddNonNumericsException;
use Consolidare\MergePatterns\Exception\FieldMismatchException;
use Consolidare\MergePatterns\MergePattern;
use Consolidare\RecordFields\Field;
use Consolidare\RecordFields\RecordField;

class Add implements MergePattern
{
    /**
     * Takes two fields and returns the sum of both the fields as a new field
     *
     * @param  RecordField $left
     * @param  RecordField $right
     * @return RecordField
     * @throws Consolidare\MergePatterns\Exception\CantAddNonNumericsException
     */
    public function merge(RecordField $left, RecordField $right)
    {
        if ($left->name() !== $right->name()) {
            throw new FieldMismatchException($left, $right);
        }

        if (!is_numeric($left->value())) {
            throw new CantAddNonNumericsException($left);
        }

        if (!is_numeric($right->value())) {
            throw new CantAddNonNumericsException($right);
        }

        return new Field(
            $left->name(),
            ($left->value() + $right->value())
        );
    }
}
