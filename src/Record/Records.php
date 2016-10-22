<?php

namespace RecordMerge\Record;

interface Records
{
    public function property($property);
    public function retrieve();
    public function revert();
}