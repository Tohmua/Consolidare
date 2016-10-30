<?php

namespace Consolidare\Mergeable\Exception;

use Consolidare\Mergeable\Exception\MergeableException;

class InvalidJsonGivenException extends MergeableException
{
    public function __construct($data)
    {
        parent::__construct('The following is not valid JSON ' . serialize($data));
    }
}