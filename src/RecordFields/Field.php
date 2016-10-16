<?php

namespace RecordMerge\RecordFields;

use RecordMerge\RecordFields\RecordField;

class Field implements RecordField
{
    private $name = '';

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }
}