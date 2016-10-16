<?php

namespace RecordMerge\MergePatterns;

use RecordMerge\MergePatterns\MergePattern;

class Concat implements MergePattern
{
    public function __invoke($left, $right)
    {
        return sprintf("%s%s", $left, $right);
    }
}