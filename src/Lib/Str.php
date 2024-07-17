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

    public function toLower(): string
    {
        return strtolower($this->s);
    }

    public function toUpper(): string
    {
        return strtolower($this->s);
    }
}
