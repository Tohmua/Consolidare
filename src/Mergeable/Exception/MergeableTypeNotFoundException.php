<?php

namespace Consolidare\Mergeable\Exception;

use Consolidare\Mergeable\Exception\MergeableException;

class MergeableTypeNotFoundException extends MergeableException
{
    public function __construct($data)
    {
        parent::__construct('Cant create a mergeable object from ' . json_encode($data));
    }
}