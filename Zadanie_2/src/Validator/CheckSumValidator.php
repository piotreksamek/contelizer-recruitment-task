<?php

declare(strict_types=1);

namespace App\Validator;

use App\Utils\Checksum;

class CheckSumValidator
{
    private const array WEIGHTS = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];

    private const int MODULO = 10;

    public static function isChecksumCorrect(string $value): bool
    {
        $checksum = Checksum::get($value, self::WEIGHTS, self::MODULO);
        $checksum = self::MODULO - $checksum % self::MODULO;

        $lastDigit = ($checksum === 10) ? 0 : $checksum;

        return $lastDigit === (int) $value[10];
    }
}
