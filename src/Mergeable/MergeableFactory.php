<?php

namespace Consolidare\Mergeable;

use Consolidare\Mergeable\Exception\MergeableTypeNotFoundException;
use Consolidare\Mergeable\Type\MergeableArray;
use Consolidare\Mergeable\Type\MergeableJsonObject;

class MergeableFactory
{
    public static function create($input)
    {
        if (is_array($input)) {
            return new MergeableArray($input);
        }

        if ($decodedJson = json_decode($input)) {
            return new MergeableJsonObject($input);
        }

        throw new MergeableTypeNotFoundException($input);
    }
}