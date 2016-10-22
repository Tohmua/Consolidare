<?php

namespace Consolidare\MergePatterns;

use Consolidare\MergePatterns\MergePattern;

class Add implements MergePattern
{
    public function __invoke($left, $right)
    {
        return $left + $right;
    }
}