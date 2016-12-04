<?php

namespace Consolidare\MergePatterns\Exception;

use Consolidare\MergePatterns\Exception\MergePatternException;
use Consolidare\RecordFields\RecordField;

class FieldMismatchException extends MergePatternException
{
    public function __construct(RecordField $left, RecordField $right)
    {
        parent::__construct(
            sprintf(
                'The two fields (%s AND %s) you are trying to merge have different names. Something has gone wrong!',
                json_encode($left->name()),
                json_encode($right->name())
            )
        );
    }
}
