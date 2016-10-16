<?php

namespace RecordMerge\Mergable\Type;

use RecordMerge\Mergable\Mergable;

class MergableArray implements Mergable
{
    private $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function retrieve()
    {
        return $this->data;
    }
}