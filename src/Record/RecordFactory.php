<?php

namespace RecordMerge\Record;

use RecordMerge\Mergable\Mergable;
use RecordMerge\MergeStrategy\MergeStrategy;
use RecordMerge\Record\Record;
use RecordMerge\Record\Records;

class RecordFactory
{
    public static function create(MergeStrategy $strategy, Records $previousRecord = NULL, Mergable $mergable)
    {
        if (!$previousRecord) {
            $previousRecord = new BlankRecord();
        }
        return new Record($strategy, $previousRecord, $mergable);
    }
}