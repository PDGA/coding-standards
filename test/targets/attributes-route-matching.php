<?php

namespace App;

class Foo
{
    public function incoming(
        #[Route(new IntPipe(), 'fooBar')] int $fooBar,
    ) {
    }
}
