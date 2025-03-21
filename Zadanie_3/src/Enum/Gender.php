<?php

declare(strict_types=1);

namespace App\Enum;

enum Gender: string
{
    case MALE = 'male';

    case FEMALE = 'female';

    public function translate(): string
    {
        return match ($this) {
            self::MALE => 'user.gender.male',
            self::FEMALE => 'user.gender.female',
        };
    }
}
