<?php

namespace Consolidare\Mergeable\Type;

use Consolidare\Mergeable\Mergeable;
use Consolidare\RecordFields\Field;

class MergeableArray implements Mergeable
{
    private $data = [];

    public function __construct(array $data)
    {
        array_walk($data, function ($value, $index) {
            $this->data[$index] = new Field($index, $value);
        });
    }

    public function retrieve()
    {
        return $this->data;
    }
}
