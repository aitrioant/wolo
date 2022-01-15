<?php

namespace App\Service;

class PhpFileFinder
{
    public function find(array $fileNames): array
    {
        $phpFiles = [];
        foreach ($fileNames as $fileName)
            if ($this->isPhpFile($fileName))
                $phpFiles[] = $this->removeExtension($fileName);

        return $phpFiles;
    }

    private function isPhpFile(string $fileName)
    {
        return str_contains($fileName, '.php');
    }

    private function removeExtension(string $fileName)
    {
        return str_replace('.php', '', $fileName);
    }
}