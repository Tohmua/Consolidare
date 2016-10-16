<?php

namespace RecordMerge;

use RecordMerge\Mergable\Mergable;
use RecordMerge\Mergable\MergableFactory;
use RecordMerge\MergeStrategy\MergeStrategy;
use RecordMerge\Record\Record;

class RecordMerge
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

    public function addMergeStrategy(MergeStrategy $strategy)
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function merge()
    {
        $record = NULL;

        foreach ($this->mergable as $data) {
            $record = new Record(
                $this->strategy,
                $record,
                $data
            );
        }

        return $record;
    }
}
