<?php

namespace Saidqb\CorePhp\Lib;

use PHLAK\StrGen;
use Saidqb\CorePhp\Lib\Str;

class Generate
{
    public static function make()
    {
        return new self();
    }
    /**
     * Generate random string
     *
     * @return StrGen\Generator
     * usage:
     * Generate::str()->lowerAlpha($length);
     * Generate::str()->upperAlpha($length);
     * Generate::str()->mixedAlpha($length);
     * Generate::str()->numeric($length);
     * Generate::str()->alphaNumeric($length);
     * Generate::str()->special($length);
     * Generate::str()->all($length);
     * Generate::str()->custom($length, $charset);
     */
    public static function str()
    {
        return new StrGen\Generator();
    }

    public static function token($salt = null, $algo = 'sha256')
    {
        if (is_null($salt)) {
            $salt = self::str()->mixedAlpha(20);
        }
        $hash = hash($algo, $salt . microtime()) . self::str()->custom(34, StrGen\CharSet::LOWER_ALPHA . StrGen\CharSet::NUMERIC);
        return Str::make($hash)->insert('-', rand(25, 30))->insert('-', rand(55, 60));
    }
}
