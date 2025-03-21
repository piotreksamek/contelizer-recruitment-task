<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class InvalidNationalIdentificationNumber extends Exception
{
    public function __construct(string $value)
    {
        $message = sprintf('Nieprawidłowy numer pesel: %s', $value);

        parent::__construct($message);
    }
}
