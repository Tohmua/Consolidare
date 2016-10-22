<?php

namespace Consolidare\Record;

interface Records
{
    public function property($property);
    public function retrieve();
    public function revert();
}