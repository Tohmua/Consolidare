<?php

namespace Consolidare;

use Consolidare\Mergeable\Mergeable;
use Consolidare\Mergeable\MergeableFactory;
use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\Record\RecordFactory;

class Merge
{
    private $config = [];
    private $mergeable = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function addData($input)
    {
        return $this->addMergeable(MergeableFactory::create($input));
    }

    public function addMergeable(Mergeable $data)
    {
        $this->mergeable[] = $data;

        return $this;
    }

    public function merge(MergeStrategy $strategy = NULL)
    {
        if (!$strategy) {
            $strategy = new MergeStrategy();
        }

        $record = NULL;

        foreach ($this->mergeable as $data) {
            $record = RecordFactory::create(
                $strategy,
                $record,
                $data
            );
        }

        return $record;
    }
}
