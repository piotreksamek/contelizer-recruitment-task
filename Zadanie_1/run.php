<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\TextProcessor;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

try {
    $processor = new TextProcessor();
    $inputFile = __DIR__ . '/input.txt';
    $outputFile = __DIR__ . '/output.txt';

    $processor->processFile($inputFile, $outputFile);

    echo "Plik został przetworzony i zapisany jako output.txt." . PHP_EOL;
} catch (FileNotFoundException $e) {

    echo "Błąd: " . $e->getMessage() . PHP_EOL;
}
