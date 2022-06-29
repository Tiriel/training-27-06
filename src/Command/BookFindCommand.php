<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BookFindCommand extends Command
{
    protected static $defaultName = 'app:book:find';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::REQUIRED, 'Required')
            ->addArgument('arg2', InputArgument::OPTIONAL, 'Optional')
            ->addArgument('arg3', InputArgument::IS_ARRAY, 'Array')
            ->addOption('option1', 'o', InputOption::VALUE_NONE, 'Option description')
            ->addOption('option2', 'a', InputOption::VALUE_NONE, 'Option description')
            ->addOption('option3', 'z', InputOption::VALUE_REQUIRED, 'Option description')
            ->addOption('option4', null, InputOption::VALUE_NEGATABLE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        $arg2 = $input->getArgument('arg2');
        $arg3 = $input->getArgument('arg3');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($arg2) {
            $io->note(sprintf('You passed an argument: %s', $arg2));
        }

        if ($arg3) {
            $io->note(sprintf('You passed an argument: %s', implode(', ', $arg3)));
        }

        if ($input->getOption('option1')) {
            $io->warning("You used an option!");
        }

        if ($input->getOption('option2')) {
            $io->warning("You used an option!");
        }

        if ($val = $input->getOption('option3')) {
            $io->warning("You used an option! " . $val);
        }

        if (null === ($bool = $input->getOption('option4'))) {
            $io->warning("You used an option! " . intval($bool));
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
