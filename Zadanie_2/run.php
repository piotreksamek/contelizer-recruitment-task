<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Exception\InvalidNationalIdentificationNumber;
use App\VerificationNationalIdentificationNumber;

if ($argc > 2) {
    echo "Podaj pesel do weryfikacji";

    return;
}

if ($argc < 2) {
    echo "Podaj tylko 1 argument";

    return;
}

try {
    $value = $argv[1];

    $nationalIdentificationNumber = new VerificationNationalIdentificationNumber($value);

    echo sprintf('Poprawny numer pesel: %s', $nationalIdentificationNumber);
} catch (InvalidNationalIdentificationNumber $e) {
    echo sprintf('Błąd: %s', $e->getMessage());
}
