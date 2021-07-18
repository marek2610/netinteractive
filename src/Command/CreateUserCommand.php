<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUser extends Command
{
  protected static $defaultName = 'app:create-user';

  public function __construct()
  {
    // ... 
  }

  protected function configure(): void
  {
    $this
      ->setDescription('Creates a new user.')

      // the full command description shown when running the command with
      // the "--help" option
      ->setHelp('This command allows you to create a user...');
  }

  public function execute(InputInterface $input, OutputInterface $output)
  {
    $output->writeln([
      'User Creator',
      '============',
      '',
    ]);

    return 0;

  }

}