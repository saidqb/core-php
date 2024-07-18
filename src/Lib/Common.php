<?php

namespace Saidqb\CorePhp\Lib;

class Common
{
    static function issetVal($data, $key = '', $default = '')
    {
        if ($key === '') {
            $isset_data = isset($data) ? $data : $default;
            return static::emptyVal($data);
        }
        if (is_array($data)) {

            $isset_data =  isset($data[$key]) ? $data[$key] : $default;
            return static::emptyVal($isset_data, $default);
        } else {

            $isset_data =  isset($data->{$key}) ? $data->{$key} : $default;
            return static::emptyVal($isset_data, $default);
        }
    }

    static function emptyVal($data, $default = '')
    {
        if ($data === 0 || $data === '0') {
            return $data;
        }

        return !empty($data) ? $data : $default;
    }
}
