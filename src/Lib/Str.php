<?php

namespace Saidqb\CorePhp\Lib;

use Str\Str as StrModule;

class Str
{

    static function make(string $str): StrModule
    {
        return new StrModule($str);
    }

    static function excerpt(string $str, int $limit = 100, string $end = '...'): string
    {
        $str = static::make($str);
        return $str->safeTruncate($limit, $end);
    }

    static function isJson($str): bool
    {
        $str = static::make($str);
        return $str->isJson();
    }

    static function toLower($str): string
    {
        return strtolower($str);
    }

    static function toUpper($str): string
    {
        return strtoupper($str);
    }


}
