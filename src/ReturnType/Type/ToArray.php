<?php

namespace Consolidare\ReturnType\Type;

use Consolidare\Record\Records;
use Consolidare\ReturnType\ReturnType;

class ToArray implements ReturnType
{
    public function __invoke(Records $record)
    {
        return array_map(function($field) {
            return $field->value();
        }, $record->retrieve());
    }
}
