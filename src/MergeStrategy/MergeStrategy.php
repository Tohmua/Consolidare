<?php

namespace Consolidare\MergeStrategy;

use Consolidare\MergePatterns\Exception\FieldMismatchException;
use Consolidare\MergePatterns\MergePattern;
use Consolidare\RecordFields\RecordField;

class MergeStrategy
{
    private $default;
    private $specific = [];


    public function __construct(MergePattern $pattern)
    {
        $this->defaultPattern($pattern);
    }

    public function defaultPattern(MergePattern $pattern)
    {
        $this->default = $pattern;

        return $this;
    }

    public function specific(RecordField $field, MergePattern $pattern)
    {
        $this->specific[$field->name()] = $pattern;

        return $this;
    }

    public function merge(RecordField $left, RecordField $right)
    {
        if ($left->name() !== $right->name()) {
            throw new FieldMismatchException($left, $right);
        }

        if (isset($this->specific[$left->name()])) {
            return $this->specific[$left->name()]->merge($left, $right);
        }

        return $this->default->merge($left, $right);
    }
}
