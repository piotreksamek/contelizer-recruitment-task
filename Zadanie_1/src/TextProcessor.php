<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class TextProcessor
{
    public function processFile(string $inputFile, string $outputFile): void
    {
        if (!file_exists($inputFile)) {
            throw new FileNotFoundException("Plik wejściowy nie istnieje.");
        }

        $content = file_get_contents($inputFile);
        $processedContent = $this->processText($content);

        file_put_contents($outputFile, $processedContent);
    }

    private function scrambleWord(string $word): string
    {
        if (mb_strlen($word) <= 3) {
            return $word;
        }

        $first = mb_substr($word, 0, 1);
        $last = mb_substr($word, -1, 1);
        $middle = mb_substr($word, 1, -1);

        $chars = preg_split('//u', $middle, -1, PREG_SPLIT_NO_EMPTY);
        shuffle($chars);

        return $first . implode('', $chars) . $last;
    }

    private function processText(string $content): string
    {
        return preg_replace_callback('/\b\p{L}{4,}\b/u', function ($matches) {
            return $this->scrambleWord($matches[0]);
        }, $content);
    }
}
