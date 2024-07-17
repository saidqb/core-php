<?php

namespace Saidqb\CorePhp\Lib;

use Str\Str as StrModule;

class Str extends StrModule
{
    private $s;

    public function __construct(string $str)
    {
        parent::__construct($str);
        $this->s = $str;
    }

    public function toUpper(string $str): string
    {
        return strtoupper($str);
    }
}
