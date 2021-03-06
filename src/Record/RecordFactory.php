<?php

namespace Consolidare\Record;

use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\Record\BlankRecord;
use Consolidare\Record\Record;
use Consolidare\Record\Records;

class RecordFactory
{
    public static function create(MergeStrategy $strategy, Records $previousRecord = NULL)
    {
        if (!$previousRecord) {
            $previousRecord = new BlankRecord();
        }
        return new Record($strategy, $previousRecord);
    }
}
