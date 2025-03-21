<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Validator\FormatValidator;
use PHPUnit\Framework\TestCase;

class FormatValidatorTest extends TestCase
{
    public function test_valid_format(): void
    {
        $nationalIdentificationNumber = '44051401351';

        $this->assertTrue(FormatValidator::isFormatValid($nationalIdentificationNumber));
    }

    public function test_invalid_format(): void
    {
        $nationalIdentificationNumber = '44051401';

        $this->assertFalse(FormatValidator::isFormatValid($nationalIdentificationNumber));
    }
}
