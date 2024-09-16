<?php

namespace Bar;

/**
 * This file is for testing that `phpcs` will
 * be triggered for the 'not camel case' for
 * files that *do not* end in `Model.php` (
 * this one ends in `ModelFile.php`).
 */
class NotModel
{
    public function FakeMethodForError()
    {
    }
}
