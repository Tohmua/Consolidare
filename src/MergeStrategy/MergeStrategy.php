<?php

namespace Consolidare\MergeStrategy;

use Consolidare\MergePatterns\MergePattern;
use Consolidare\MergePatterns\Right;
use Consolidare\RecordFields\RecordField;

class MergeStrategy
{
    private $default;
    private $specific = [];


    public function __construct(MergePattern $pattern = NULL)
    {
        if (!$pattern) {
            $pattern = new Right();
        }

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

    public function merge($field, $left, $right)
    {
        if (isset($this->specific[$field])) {
            $mergePattern = $this->specific[$field];
            return $mergePattern($left, $right);
        }

        $mergePattern = $this->default;
        return $mergePattern($left, $right);
    }
}