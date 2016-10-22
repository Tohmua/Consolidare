<?php

namespace Consolidare\Mergable\Type;

use Consolidare\Mergable\Exception\InvalidJsonGivenException;
use Consolidare\Mergable\Mergable;

class MergableJsonObject implements Mergable
{
    private $data = [];

    public function __construct(string $data)
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