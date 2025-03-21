<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Validator\CheckSumValidator;
use PHPUnit\Framework\TestCase;

class ChecksumValidatorTest extends TestCase
{
    public function test_valid_checksum(): void
    {
        $nationalIdentificationNumber = '44051401359';

        $this->assertTrue(CheckSumValidator::isChecksumCorrect($nationalIdentificationNumber));
    }

    public function test_invalid_checksum(): void
    {
        $nationalIdentificationNumber = '44051401358';

        $this->assertFalse(CheckSumValidator::isChecksumCorrect($nationalIdentificationNumber));
    }
}
