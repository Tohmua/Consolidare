<?php

namespace Consolidare\Mergeable\Type;

use Consolidare\Mergeable\Exception\InvalidJsonGivenException;
use Consolidare\Mergeable\Mergeable;

class MergeableJsonObject implements Mergeable
{
    private $data = [];

    public function __construct($data)
    {
        $data = json_decode($data);

        if (!$data) {
            throw new InvalidJsonGivenException($data);
        }

        foreach ($data as $property => $value) {
            $this->data[$property] = $value;
        }
    }

    public function retrieve()
    {
        return $this->data;
    }
}