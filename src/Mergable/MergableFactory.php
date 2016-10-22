<?php

namespace Consolidare\Mergable;

use Consolidare\Mergable\Exception\MergableTypeNotFoundException;
use Consolidare\Mergable\Type\MergableArray;
use Consolidare\Mergable\Type\MergableJsonObject;

class MergableFactory
{
    public static function create($input)
    {
        if (is_array($input)) {
            return new MergableArray($input);
        }

        if ($decodedJson = json_decode($input)) {
            return new MergableJsonObject($input);
        }

        throw new MergableTypeNotFoundException($input);
    }
}