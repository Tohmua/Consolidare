<?php

namespace Consolidare;

use Consolidare\Mergable\Mergable;
use Consolidare\Mergable\MergableFactory;
use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\MergeStrategy\MissingMergeStrategyException;
use Consolidare\Record\RecordFactory;

class Merge
{
    private $config = [];
    private $mergable = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function addData($input)
    {
        return $this->addMergable(MergableFactory::create($input));
    }

    public function addMergable(Mergable $data)
    {
        $this->mergable[] = $data;

        return $this;
    }

    public function merge(MergeStrategy $strategy = NULL)
    {
        if (!$strategy) {
            $strategy = new MergeStrategy();
        }

        $record = NULL;

        foreach ($this->mergable as $data) {
            $record = RecordFactory::create(
                $strategy,
                $record,
                $data
            );
        }

        return $record;
    }
}
