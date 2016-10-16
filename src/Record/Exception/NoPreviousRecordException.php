<?php

namespace RecordMerge\Record\Exception;

use RecordMerge\Record\Exception\RecordException;

class NoPreviousRecordException extends RecordException
{
    public function __construct()
    {
        parent::__construct('No previous record set.');
    }
}