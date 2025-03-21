<?php

declare(strict_types=1);

namespace App\Validator;

class FormatValidator
{
    public const int LENGTH = 11;

    public static function isFormatValid(string $value): bool
    {
        return (bool) preg_match('/^\d{' . self::LENGTH . '}$/', $value);
    }
}
