<?php

namespace Component\Library\Util;

/**
 * Class String
 * @package Component\Library\Util
 */
class String
{
    public static function underscore($str)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]/', '_\0', $str)), '_');
    }

    public static function camelize($str)
    {
        return lcfirst(strtr(ucwords(strtr($str, ['_' => ' '])), [' ' => '']));
    }
}