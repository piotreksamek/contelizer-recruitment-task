<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Utils\Checksum;
use PHPUnit\Framework\TestCase;

class ChecksumTest extends TestCase
{
    public function test_checksum_calculation(): void
    {
        $nationalIdentificationNumber = '44051401359';
        $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
        $modulo = 10;

        $checksum = Checksum::get($nationalIdentificationNumber, $weights, $modulo);

        $this->assertEquals(1, $checksum);
    }

    public function test_checksum_invalid_calculation(): void
    {
        $nationalIdentificationNumber = '44051401359';
        $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
        $modulo = 10;

        $checksum = Checksum::get($nationalIdentificationNumber, $weights, $modulo);

        $this->assertNotEquals(5, $checksum);
    }
}
