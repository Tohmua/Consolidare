<?php

namespace Consolidare\MergePatterns;

use Consolidare\MergePatterns\MergePattern;

class Left implements MergePattern
{
    public function __invoke($left, $right)
    {
        return $left;
    }
}