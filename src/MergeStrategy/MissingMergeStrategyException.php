<?php

namespace Consolidare\MergeStrategy;

use Consolidare\MergeStrategy\MergeStrategyException;

class MissingMergeStrategyException extends MergeStrategyException
{
    public function __construct()
    {
        parent::__construct('You need to add a merge strategy.');
    }
}