<?php

namespace Consolidare\Record;

use Consolidare\Mergable\Mergable;
use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\Record\Exception\CantRevertBackFurtherException;
use Consolidare\Record\Exception\NoPreviousRecordException;
use Consolidare\Record\Exception\PropertyDoesNotExistException;
use Consolidare\Record\Exception\RecordException;
use Consolidare\Record\Record;
use Consolidare\Record\Records;

class Record implements Records
{
    private $properties = [];
    private $previousRecord;

    public function __construct(MergeStrategy $strategy, Records $previousRecord, Mergable $mergable)
    {
        $this->loadPreviousRecord($previousRecord);
        $this->merge($strategy, $previousRecord, $mergable);
    }

    public function property($property)
    {
        if (!isset($this->properties[$property])) {
            throw new PropertyDoesNotExistException();
        }

        return $this->properties[$property];
    }

    public function retrieve()
    {
        return $this->properties;
    }

    public function revert()
    {
        return $this->previousRecord;
    }

    private function loadPreviousRecord(Records $previousRecord)
    {
        $this->previousRecord = $previousRecord;
        $this->properties = $previousRecord->retrieve();
    }

    private function merge(MergeStrategy $strategy, Records $previousRecord, Mergable $mergable)
    {
        foreach ($mergable->retrieve() as $property => $value) {
            try {
                $this->properties[$property] = $strategy->merge(
                    $property,
                    $previousRecord->property($property),
                    $value
                );
            } catch (RecordException $e) {
                $this->properties[$property] = $value;
            }
        }
    }
}