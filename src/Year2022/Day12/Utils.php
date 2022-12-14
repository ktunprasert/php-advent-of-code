<?php

namespace App\Year2022\Day12;

class Utils
{
    public static function convertValue(string $char): int
    {
        switch ($char) {
            case "S":
                return 0;
            case "E":
                return 27;
            case $char >= 'a' && $char <= 'z':
                return ord($char) - 96;
            default:
                return 0;
        }
    }
}
