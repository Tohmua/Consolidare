<?php

namespace Consolidare\Mergeable\Type;

use Consolidare\Mergeable\Mergeable;

class MergeableArray implements Mergeable
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