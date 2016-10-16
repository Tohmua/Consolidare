<?php

namespace RecordMerge\MergePatterns;

use RecordMerge\MergePatterns\MergePattern;

class Add implements MergePattern
{
    public function __invoke($left, $right)
    {
        return $left + $right;
    }
}