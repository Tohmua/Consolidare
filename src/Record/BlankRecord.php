<?php

namespace RecordMerge\Record;

use RecordMerge\Record\Exception\CantRevertBackFurtherException;
use RecordMerge\Record\Exception\PropertyDoesNotExistException;

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