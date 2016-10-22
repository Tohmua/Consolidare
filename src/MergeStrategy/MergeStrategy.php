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

        $this->default($pattern);
    }

    public function default(MergePattern $pattern)
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
            return ($this->specific[$field])($left, $right);
        }

        return ($this->default)($left, $right);
    }
}