<?php

declare(strict_types=1);

namespace App;

use App\Exception\InvalidNationalIdentificationNumber;
use App\Validator\CheckSumValidator;
use App\Validator\FormatValidator;
use DateTimeImmutable;
use Stringable;

class VerificationNationalIdentificationNumber implements Stringable
{
    private const int MONTH_CENTURY_OFFSET = 20;

    private readonly string $value;

    public function __construct(
        string $value,
    ) {
        $this->validate($value);

        $birthDate = $this->extractBirthDate($value);

        $this->validateNotFromFuture($birthDate);

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function validate(string $value): void
    {
        if (!FormatValidator::isFormatValid($value) || !CheckSumValidator::isChecksumCorrect($value)) {
            throw new InvalidNationalIdentificationNumber($value);
        }
    }

    private function extractBirthDate(string $value): DateTimeImmutable
    {
        $encodedMonth = (int) substr($value, 2, 2);
        $month = $this->getMonth($encodedMonth);
        $this->validateMonth($month);

        $year = $this->getYear($encodedMonth, $value);

        $day = (int) substr($value, 4, 2);
        $this->validateDay($day, $month, $year);

        return new DateTimeImmutable("$year-$month-$day");
    }

    private function getMonth(int $encodedMonth): int
    {
        return $encodedMonth % self::MONTH_CENTURY_OFFSET;
    }

    private function validateMonth(int $month): void
    {
        if ($month < 1 || $month > 12) {
            throw new InvalidNationalIdentificationNumber($this->value);
        }
    }

    private function getYear(int $encodedMonth, string $value): int
    {
        $monthToCenturyOffset = [
            80 => 1800,
            0 => 1900,
            20 => 2000,
            40 => 2100,
        ];

        foreach ($monthToCenturyOffset as $monthCenturyOffset => $firstYearOfCentury) {
            if ($this->getMonth($encodedMonth) === $encodedMonth - $monthCenturyOffset) {
                return $firstYearOfCentury + (int) substr($value, 0, 2);
            }
        }

        throw new InvalidNationalIdentificationNumber($value);
    }

    private function validateDay(int $day, int $month, int $year): void
    {
        $maxDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        if ($day > $maxDays || $day <= 0) {
            throw new InvalidNationalIdentificationNumber($this->value);
        }
    }

    private function validateNotFromFuture(DateTimeImmutable $birthDate): void
    {
        $currentDate = (new DateTimeImmutable())->setTime(0, 0);

        if ($birthDate > $currentDate) {
            throw new InvalidNationalIdentificationNumber($this->value);
        }
    }
}
