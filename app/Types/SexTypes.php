<?php

namespace App\Types;

enum SexTypes: string
{
    case male = 'Male';
    case female = 'Female';

    public static function toArray(): array
    {
        return self::cases();
    }
}
