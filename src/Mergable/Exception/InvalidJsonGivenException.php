<?php

namespace Consolidare\Mergable\Exception;

use Consolidare\Mergable\Exception\MergableException;

class InvalidJsonGivenException extends MergableException
{
    public function __construct($data)
    {
        parent::__construct('The following is not valid JSON ' . serialize($data));
    }
}