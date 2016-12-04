<?php

namespace Consolidare\MergePatterns;

use Consolidare\RecordFields\RecordField;

interface MergePattern
{
    /**
     * Takes two fields and returns a field
     *
     * @param  RecordField $left
     * @param  RecordField $right
     * @return RecordField
     */
    public function merge(RecordField $left, RecordField $right);
}
