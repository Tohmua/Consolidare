<?php

namespace Consolidare\MergePatterns\Exception;

use Consolidare\MergePatterns\Exception\MergePatternException;
use Consolidare\RecordFields\RecordField;

class CantAddNonNumericsException extends MergePatternException
{
    public function __construct(RecordField $field)
    {
        parent::__construct(
            sprintf(
                'You can only add numeric values for field %s. %s was not a valid numeric value.',
                json_encode($field->name()),
                json_encode($field->value())
            )
        );
    }
}
