<?php

namespace Consolidare\Mergeable;

interface Mergeable
{
    /**
     * Returns an array of the fields. Where the field name is the
     * key however it contains a field object.
     *
     * @return array
     * [
     *      'field_1' => new Consolidare\RecordFields\Field('field_1', 'Dave'),
     * ]
     */
    public function retrieve();
}
