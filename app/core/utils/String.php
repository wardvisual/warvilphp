<?php

namespace app\core\utils;

class StringHelper
{
    public static function truncate($inputString, $maxLength)
    {
        if (strlen($inputString) <= $maxLength) {
            return $inputString;
        }
        return substr($inputString, 0, $maxLength) . '...';
    }
}
