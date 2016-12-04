<?php

namespace Consolidare\RecordFields;

use Consolidare\RecordFields\RecordField;

class Field implements RecordField
{
    private $name = '';
    private $value = '';

    public function __construct($name, $value = NULL)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function name()
    {
        return $this->name;
    }

    public function value()
    {
        return $this->value;
    }
}
