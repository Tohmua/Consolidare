<?php

namespace Consolidare\MergePatterns;

interface MergePattern
{
    public function __invoke($left, $right);
}