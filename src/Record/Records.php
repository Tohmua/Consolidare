<?php

namespace Consolidare\Record;

use Consolidare\RecordFields\RecordField;

interface Records
{
    public function field(RecordField $field);
    public function retrieve();
    public function revert();
}
