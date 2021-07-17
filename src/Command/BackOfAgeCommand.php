<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;


class BackOfAgeCommand extends Command
{

  protected static $defaultName = 'app:back-of-age';

  
  private $entityManager;
  
  public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
  {
    
    $this->entityManager = $entityManager;
    $this->mailer = $mailer;
    
    parent::__construct();
  }
  
  protected function configure()
  {
      // ...
  }

  public function execute(InputInterface $input, OutputInterface $output)
  {
    // ustawiamy date narodzin na Date() -18 lat
    $date = new \DateTime(date("Y-m-d"));
    $date->modify('-18 years');
    $date->format("Y-m-d");


    // pobieramy z zbazy danych wszystkich userów któ©zy mają dzisiaj urodziny
    $em = $this->entityManager;
    $pelnoletni = $em->getRepository(User::class)->findBy(
      [
      'isVerified' => true,
      'dob' => $date
      ],
    );

    $output->writeln(sprintf("Znaleziono %d niepełnoletnich userów", count($pelnoletni)));

    // zmianiamy status na aktywny
    foreach ($pelnoletni as $pelno) {
      $pelno
        ->setIsVerified(false)
      ;
      
      $em->persist($pelno);
    }
    // zapisujemy w bazie
    $em->flush();

    // komunikat o zmianie statusu
    $output->writeln(sprintf('<fg=#c0392b>Zaktualizowano status %d userów</>', count($pelnoletni)));

    return 0;
  }
}