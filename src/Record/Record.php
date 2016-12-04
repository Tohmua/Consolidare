<?php

namespace Consolidare\Record;

use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\Mergeable\Mergeable;
use Consolidare\RecordFields\Field;
use Consolidare\RecordFields\RecordField;
use Consolidare\Record\Exception\PropertyDoesNotExistException;
use Consolidare\Record\Exception\RecordException;
use Consolidare\Record\Records;

class Record implements Records
{
    private $fields = [];
    private $previousRecord;
    private $strategy;

    public function __construct(MergeStrategy $strategy, Records $previousRecord)
    {
        $this->strategy = $strategy;
        $this->previousRecord = $previousRecord;

        $this->loadPreviousRecord();
    }

    public function field(RecordField $field)
    {
        if (!isset($this->fields[$field->name()])) {
            throw new PropertyDoesNotExistException();
        }

        return $this->fields[$field->name()];
    }

    public function retrieve()
    {
        return $this->fields;
    }

    public function revert()
    {
        return $this->previousRecord;
    }

    public function merge(Mergeable $mergeable)
    {
        foreach ($mergeable->retrieve() as $field) {
            try {
                $this->fields[$field->name()] = $this->strategy->merge(
                    $this->previousRecord->field($field),
                    $field
                );
            } catch (RecordException $e) {
                $this->fields[$field->name()] = $field;
            }
        }

        return $this;
    }

    private function loadPreviousRecord()
    {
        $this->fields = $this->previousRecord->retrieve();
    }
}
