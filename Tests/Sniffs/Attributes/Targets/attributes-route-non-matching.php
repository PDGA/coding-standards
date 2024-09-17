<?php

namespace App;

class Foo
{
    public function incoming(
        #[Route(new IntPipe(), 'fooBaz')] int $foo_baz,
    ) {
    }
}
