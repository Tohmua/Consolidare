<?php

namespace RecordMerge\Record;

use RecordMerge\Mergable\Mergable;
use RecordMerge\Record\InvalidRecordArgumentException;
use RecordMerge\Record\Record;

class RecordFactory
{
    public static function fromMergable(Mergable $mergable)
    {
        return new Record($mergable->get());
    }
}