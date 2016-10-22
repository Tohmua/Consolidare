<?php

namespace Consolidare\Record\Exception;

use Consolidare\Record\Exception\RecordException;

class NoPreviousRecordException extends RecordException
{
    public function __construct()
    {
        parent::__construct('No previous record set.');
    }
}