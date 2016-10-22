<?php

namespace Consolidare\RecordFields;

use Consolidare\RecordFields\RecordField;

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