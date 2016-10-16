<?php

namespace RecordMerge\MergePatterns;

use RecordMerge\MergePatterns\MergePattern;

class Left implements MergePattern
{
    public function __invoke($left, $right)
    {
        return $left;
    }
}