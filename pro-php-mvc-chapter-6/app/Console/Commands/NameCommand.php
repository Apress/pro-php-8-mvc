<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NameCommand extends Command
{
    protected static $defaultName = 'name';

    protected $requireName = false;

    protected function configure()
    {
        $this
            ->setDescription('Prints the name in uppercase')
            ->setHelp('This command takes an optional name and returns it in uppercase. If no name is provided, "stranger" is used.')
            ->addArgument('name', $this->requireName ? InputArgument::REQUIRED : InputArgument::OPTIONAL, 'Optional name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(strtoupper($input->getArgument('name') ?: 'Stranger'));
        
        return Command::SUCCESS;
    }
}
