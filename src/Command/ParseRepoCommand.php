<?php

namespace App\Command;

use App\Service\PascalCaseWordCounter;
use App\Service\PascalCaseWordSplitter;
use App\Service\PhpFileNamesFinder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseRepoCommand extends Command
{
    const PATH_ARG = 'path';

    protected static $commandName = 'app:walk-repo';

    private string $path;

    private PhpFileNamesFinder $walker;
    private PascalCaseWordCounter $wordCounter;

    public function __construct(PhpFileNamesFinder $walker, PascalCaseWordCounter $wordCounter, string $path = '/home/aitrioant/Documents/projects/wolo')
    {
        $this->path = $path;
        $this->walker = $walker;

        parent::__construct();
        $this->wordCounter = $wordCounter;
    }


    protected function configure(): void
    {
        $arg = $this->addArgument(self::PATH_ARG);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $inputPath = $input->getArgument(self::PATH_ARG);
            if (!empty($inputPath))
                $this->path = $inputPath;

            $phpFileNames = $this->walker->walk($this->path);
            $result = $this->wordCounter->count($phpFileNames);

            $this->printResults($result, $output);

            return Command::SUCCESS;

        } catch (\Throwable $exception) {
            return Command::FAILURE;
        }
    }

    private function printResults($words, OutputInterface $output)
    {
        foreach ($words as $word => $count) {
            $output->writeln($word . ': ' . $count);
        }
    }
}