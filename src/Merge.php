<?php

namespace Consolidare;

use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\Mergeable\Mergeable;
use Consolidare\Mergeable\MergeableFactory;
use Consolidare\Record\RecordFactory;

class Merge
{
    private $mergeable = [];

    public function data($input)
    {
        return $this->mergeable(MergeableFactory::create($input));
    }

    public function mergeable(Mergeable $data)
    {
        $this->mergeable[] = $data;

        return $this;
    }

    public function merge(MergeStrategy $strategy)
    {
        return array_reduce($this->mergeable, function ($record, $data) use ($strategy) {
            return RecordFactory::create(
                $strategy,
                $record,
                $data
            );
        });
    }
}
