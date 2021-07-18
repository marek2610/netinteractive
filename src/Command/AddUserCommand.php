<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;


class AddUserCommand extends Command
{

  protected static $defaultName = 'app:add-user';

  private $entityManager;
  
  public function __construct(EntityManagerInterface $entityManager)
  {
  
    $this->entityManager = $entityManager;
    
    parent::__construct();
  }

  protected function configure(): void
  {
    $this
      // the short description shown while running "php bin/console list"
      ->setDescription('Creates a new user.')

      // the full command description shown when running the command with
      // the "--help" option
      ->setHelp('This command allows you to create a user...');
  }

  public function execute(InputInterface $input, OutputInterface $output)
  {
    // outputs multiple lines to the console (adding "\n" at the end of each line)
    $output->writeln([
      'User Creator',
      '============',
      '',
  ]);

    // outputs a message followed by a "\n"
    $output->writeln('Whoa!');

    // outputs a message without adding a "\n" at the end of the line
    $output->writeln('You are about to ');
    $output->writeln('create a user.');

    return 0;
  }
}