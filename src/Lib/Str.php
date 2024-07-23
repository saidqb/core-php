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

    static function toCamelCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
    }

    static function toSnakeCase(string $string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }

    static function toKebabCase(string $string): string
    {
        return str_replace('_', '-', $string);
    }

    static function toTitleCase(string $string): string
    {
        return preg_replace('/\s+/', ' ', ucwords(preg_replace('/(?<!^)[A-Z]/', ' $0', static::toCamelCase($string))));
    }

    static function toSlug(string $string): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
    }

    static function removePrefix(string $string, string $prefix): string
    {
        $strCount = strlen($prefix);
        if (substr($string, 0, $strCount) == $prefix) {
            $string = trim(substr($string, $strCount));
        }
        return $string;
    }
}
