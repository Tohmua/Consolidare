<?php

namespace Consolidare\Mergeable\Type;

use Consolidare\Mergeable\Exception\InvalidJsonGivenException;
use Consolidare\Mergeable\Mergeable;
use Consolidare\RecordFields\Field;

class MergeableJsonObject implements Mergeable
{
    private $data = [];

    public function __construct($data)
    {
        $data = json_decode($data);

        if (!$data) {
            throw new InvalidJsonGivenException($data);
        }

        array_walk($data, function ($value, $index) {
            $this->data[$index] = new Field($index, $value);
        });
    }

    public function retrieve()
    {
        return $this->data;
    }
}
