<?php

namespace Saidqb\CorePhp\Lib;

use Str\Str as StrModule;

class Str
{

    static function set(string $str): StrModule
    {
        return new StrModule($str);
    }

    static function isJson($str): bool
    {
        $str = new StrModule($str);
        return $str->isJson();
    }



    static function toLower($str): string
    {
        return strtolower($str);
    }

    static function toUpper($str): string
    {
        return strtolower($str);
    }
}
