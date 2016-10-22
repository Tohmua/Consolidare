<?php

namespace Consolidare\MergePatterns;

use Consolidare\MergePatterns\MergePattern;

class Concat implements MergePattern
{
    public function __invoke($left, $right)
    {
        return sprintf("%s%s", $left, $right);
    }
}