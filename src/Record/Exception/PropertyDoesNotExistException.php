<?php

namespace RecordMerge\Record\Exception;

use RecordMerge\Record\Exception\RecordException;

class PropertyDoesNotExistException extends RecordException
{
    public function __construct()
    {
        parent::__construct('Property does not exist');
    }
}