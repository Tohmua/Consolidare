<?php

namespace Consolidare\Record;

use Consolidare\Record\Exception\CantRevertBackFurtherException;
use Consolidare\Record\Exception\PropertyDoesNotExistException;

class BlankRecord implements Records
{
    public function __construct()
    {
    }

    public function property($property)
    {
        throw new PropertyDoesNotExistException();
    }

    public function retrieve()
    {
        return [];
    }

    public function revert()
    {
        throw new CantRevertBackFurtherException();
    }
}