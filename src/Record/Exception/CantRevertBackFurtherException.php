<?php

namespace Consolidare\Record\Exception;

use Consolidare\Record\Exception\RecordException;

class CantRevertBackFurtherException extends RecordException
{
    public function __construct()
    {
        parent::__construct('You cant revert back before the original record.');
    }
}