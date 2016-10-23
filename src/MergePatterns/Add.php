<?php

namespace Consolidare\MergePatterns;

use Consolidare\MergePatterns\Exception\CantAddNonNumericsException;
use Consolidare\MergePatterns\MergePattern;

class Add implements MergePattern
{
    public function __invoke($left, $right)
    {
        if (!is_numeric($left)) {
            throw new CantAddNonNumericsException($left);
        }

        if (!is_numeric($right)) {
            throw new CantAddNonNumericsException($right);
        }

        return $left + $right;
    }
}