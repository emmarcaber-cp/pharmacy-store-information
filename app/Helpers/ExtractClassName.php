<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class ExtractClassName
{
    /**
     * Extract the class name from a string.
     *
     * @param string $string
     * @return string
     */
    public static function extract(string $class): string
    {
        $className = class_basename($class);

        return Str::of($className)
            ->snake()
            ->replace('_', ' ')
            ->lower();
    }
}
