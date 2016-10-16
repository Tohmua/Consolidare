<?php

namespace RecordMerge\MergePatterns;

interface MergePattern
{
    public function __invoke($left, $right);
}