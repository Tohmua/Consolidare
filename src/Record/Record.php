<?php

namespace RecordMerge\Record;

use RecordMerge\Mergable\Mergable;
use RecordMerge\MergeStrategy\MergeStrategy;
use RecordMerge\Record\Exception\CantRevertBackFurtherException;
use RecordMerge\Record\Exception\NoPreviousRecordException;
use RecordMerge\Record\Exception\PropertyDoesNotExistException;
use RecordMerge\Record\Exception\RecordException;
use RecordMerge\Record\Record;

class Record implements Records
{
    private $properties = [];
    private $previousRecord;

    public function __construct(MergeStrategy $strategy, Record $previousRecord = NULL, Mergable $mergable)
    {
        if ($previousRecord) {
            $this->previousRecord = $previousRecord;
            $this->loadPreviousRecord($previousRecord);
        }

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
        if (!$this->previousRecord) {
            throw new CantRevertBackFurtherException();
        }

        return $this->previousRecord;
    }

    private function loadPreviousRecord(Record $previousRecord)
    {
        $this->properties = $previousRecord->retrieve();
    }

    private function merge(MergeStrategy $strategy, Record $previousRecord = NULL, Mergable $mergable)
    {
        foreach ($mergable->retrieve() as $property => $value) {
            try {
                if (!$previousRecord) {
                    throw new NoPreviousRecordException();
                }

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