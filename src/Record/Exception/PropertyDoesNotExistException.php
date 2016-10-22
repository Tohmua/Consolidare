<?php

namespace Consolidare\Record\Exception;

use Consolidare\Record\Exception\RecordException;

class PropertyDoesNotExistException extends RecordException
{
    public function __construct()
    {
        parent::__construct('Property does not exist');
    }
}