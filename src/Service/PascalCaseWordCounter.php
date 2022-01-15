<?php

namespace App\Service;

class PascalCaseWordCounter
{
    private PascalCaseWordSplitter $wordFinder;

    /**
     * @param PascalCaseWordSplitter $wordFinder
     */
    public function __construct(PascalCaseWordSplitter $wordFinder)
    {
        $this->wordFinder = $wordFinder;
    }

    public function count(array $pascalCaseNames)
    {
        $words = $this->wordFinder->split($pascalCaseNames);

        return $this->countWords($words);
    }

    private function countWords(array $words): array
    {
        $count = [];
        foreach ($words as $word) {
            if (!isset($count[$word]))
                $count[$word] = 0;

            $count[$word] = $count[$word] + 1;
        }

        return $count;
    }
}