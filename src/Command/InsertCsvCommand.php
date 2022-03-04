<?php

namespace App\Command;

use App\Service\ImportCsvService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InsertCsvCommand extends Command
{
    protected static $defaultName = 'app:insert-csv';
    protected static $defaultDescription = 'Add a short description for your command';

    /** @var ImportCsvService */
    private $importCsvService;

    public function __construct(ImportCsvService $importCsvService, string $name = null)
    {
        parent::__construct($name);
        $this->importCsvService = $importCsvService;
    }

    protected function configure(): void
    {
        $this->setDescription(self::getDefaultDescription());
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->importCsvService->start();

        return Command::SUCCESS;
    }
}
