<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Exception\InvalidNationalIdentificationNumber;
use App\VerificationNationalIdentificationNumber;
use PHPUnit\Framework\TestCase;

class VerificationNationalIdentificationNumberTest extends TestCase
{
    public function testValidNationalIdentificationNumber(): void
    {
        $nationalIdentificationNumber = '44051401359';

        $verificationData = new VerificationNationalIdentificationNumber($nationalIdentificationNumber);

        $this->assertSame($nationalIdentificationNumber, (string) $verificationData);
    }

    public function testInvalidNationalIdentificationNumberFormat(): void
    {
        $this->expectException(InvalidNationalIdentificationNumber::class);

        new VerificationNationalIdentificationNumber('123456789');
    }

    public function testInvalidNationalIdentificationNumberChecksum(): void
    {
        $this->expectException(InvalidNationalIdentificationNumber::class);

        new VerificationNationalIdentificationNumber('44051401358');
    }

    public function testInvalidNationalIdentificationNumberDay(): void
    {
        $this->expectException(InvalidNationalIdentificationNumber::class);

        new VerificationNationalIdentificationNumber('66666666666');
    }

    public function testBirthDateFromFuture(): void
    {
        $this->expectException(InvalidNationalIdentificationNumber::class);

        new VerificationNationalIdentificationNumber('44051499999');
    }
}
