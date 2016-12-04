<?php

namespace Consolidare\MergeStrategy;

use Consolidare\MergePatterns\Right;
use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\RecordFields\Field;

class MergeStrategyFactory
{
    public static function basic()
    {
        return new MergeStrategy(new Right);
    }
}
