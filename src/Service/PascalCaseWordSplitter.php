<?php

namespace App\Service;

class PascalCaseWordSplitter
{
    public function split(array $names): array
    {
        $words = [];
        foreach ($names as $name)
            $words = [...$words, ...preg_split('/(?=[A-Z])/', $name)];

        return self::removeEmpty($words);
    }

    private function removeEmpty(array $words): array
    {
        return array_filter($words, fn($word) => !empty($word));
    }
}