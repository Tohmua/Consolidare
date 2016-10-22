<?php

namespace Consolidare\MergePatterns;

use Consolidare\MergePatterns\MergePattern;

class Right implements MergePattern
{
    public function __invoke($left, $right)
    {
        return $right;
    }
}