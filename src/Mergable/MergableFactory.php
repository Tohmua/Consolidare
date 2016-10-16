<?php

namespace RecordMerge\Mergable;

use RecordMerge\Mergable\Exception\MergableTypeNotFoundException;
use RecordMerge\Mergable\Type\MergableArray;
use RecordMerge\Mergable\Type\MergableJsonObject;

class MergableFactory
{
    public static function create($input)
    {
        if (is_array($input)) {
            return new MergableArray($input);
        }

        if ($decodedJson = json_decode($input)) {
            return new MergableJsonObject($decodedJson);
        }

        throw new MergableTypeNotFoundException($input);
    }
}