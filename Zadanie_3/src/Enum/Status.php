<?php

declare(strict_types=1);

namespace App\Enum;

enum Status: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';

    public function translate(): string
    {
        return match ($this) {
            self::ACTIVE => 'user.status.active',
            self::INACTIVE => 'user.status.inactive',
        };
    }
}
