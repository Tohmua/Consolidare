<?php

namespace Consolidare\ReturnType;

use Consolidare\Record\Records;

interface ReturnType {
    public function __invoke(Records $record);
}
