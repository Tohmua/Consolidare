<?php

namespace Consolidare\Record;

use Consolidare\Mergeable\Mergeable;
use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\Record\Record;
use Consolidare\Record\Records;

class RecordFactory
{
    public static function create(MergeStrategy $strategy, Records $previousRecord = NULL, Mergeable $mergeable)
    {
        if (!$previousRecord) {
            $previousRecord = new BlankRecord();
        }
        return new Record($strategy, $previousRecord, $mergeable);
    }
}