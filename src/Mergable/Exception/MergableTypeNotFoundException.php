<?php

namespace RecordMerge\Mergable\Exception;

use RecordMerge\Mergable\Exception\MergableException;

class MergableTypeNotFoundException extends MergableException
{
    public function __construct($data)
    {
        parent::__construct('Cant create a mergable object from ' . json_encode($data));
    }
}