<?php

namespace App\Service;

class PhpFileNamesFinder
{
    private static array $files = [];

    private PhpFileFinder $fileFinder;

    public function __construct(PhpFileFinder $fileFinder)
    {
        $this->fileFinder = $fileFinder;
    }

    public function walk(string $path): array
    {
        $this->retrieveAllFilesAndFolderOfPath($path);

        return $this->fileFinder->find(self::$files);
    }

    private function retrieveAllFilesAndFolderOfPath(string $path): void
    {
        $filesOrFolders = scandir($path);

        unset($filesOrFolders[array_search('.', $filesOrFolders, true)]);
        unset($filesOrFolders[array_search('..', $filesOrFolders, true)]);

        if (count($filesOrFolders) < 1)
            return;

        foreach($filesOrFolders as $fileOrFolder){
            self::$files[] = $fileOrFolder;
            if(is_dir($path.'/'.$fileOrFolder)) $this->retrieveAllFilesAndFolderOfPath($path . '/' . $fileOrFolder);
        }
    }
}