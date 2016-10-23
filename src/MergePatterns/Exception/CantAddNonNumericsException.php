<?php

namespace Consolidare\MergePatterns\Exception;

use Consolidare\MergePatterns\Exception\MergePatternException;

class CantAddNonNumericsException extends MergePatternException
{
    public function __construct($value)
    {
        parent::__construct(
            sprintf(
                'You can only add numeric values. %s was not a valid numeric value.',
                json_encode($value)
            )
        );
    }
}