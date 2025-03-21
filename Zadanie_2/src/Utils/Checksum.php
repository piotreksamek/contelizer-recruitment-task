<?php

declare(strict_types=1);

namespace App\Utils;

class Checksum
{
    public static function get(string $value, array $weights, int $modulo): int
    {
        $sum = 0;

        for ($i = 0; $i < count($weights); $i++) {
            $sum += (int) $value[$i] * $weights[$i];
        }

        return $sum % $modulo;
    }
}
