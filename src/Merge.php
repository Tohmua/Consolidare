<?php

namespace Consolidare;

use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\Mergeable\Mergeable;
use Consolidare\Mergeable\MergeableFactory;
use Consolidare\Record\RecordFactory;

class Merge
{
    private $mergeables = [];

    public function data($input)
    {
        return $this->mergeable(MergeableFactory::create($input));
    }

    public function mergeable(Mergeable $mergeable)
    {
        $this->mergeables[] = $mergeable;

        return $this;
    }

    public function merge(MergeStrategy $strategy)
    {
        return array_reduce($this->mergeables, function ($record, $mergeable) use ($strategy) {
            return RecordFactory::create($strategy, $record)->merge($mergeable);
        });
    }
}
