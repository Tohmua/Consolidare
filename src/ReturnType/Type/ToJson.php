<?php

namespace Consolidare\ReturnType\Type;

use Consolidare\Record\Records;
use Consolidare\ReturnType\ReturnType;

class ToJson implements ReturnType
{
    public function __invoke(Records $record)
    {
        return json_encode(array_map(function($field) {
            return $field->value();
        }, $record->retrieve()));
    }
}
