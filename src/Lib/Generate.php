<?php

namespace Saidqb\CorePhp\Lib;

use PHLAK\StrGen;

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

}
