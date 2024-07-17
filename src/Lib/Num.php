<?php

namespace Saidqb\CorePhp\Lib;

class Num
{
    private $n;

    public function __construct(int $num)
    {
        $this->n = $num;
    }

    public function add(int $num): int
    {
        return $this->n + $num;
    }

    public function sub(int $num): int
    {
        return $this->n - $num;
    }

    public function mul(int $num): int
    {
        return $this->n * $num;
    }

    public function div(int $num): int
    {
        return $this->n / $num;
    }
}
