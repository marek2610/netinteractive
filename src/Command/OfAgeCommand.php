<?php

namespace App\Command;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OfAgeCommand extends Command
{

  protected static $defaultName = 'app:of-age';

  
  private $entityManager;
  
  public function __construct(EntityManagerInterface $entityManager)
  {
    
    $this->entityManager = $entityManager;
    
    parent::__construct();
  }
  
  // protected function configure()
  // {
  //   $this
  //     ->setName('app:of_age')
  //     ->setDescription("Komenda aktywująca Usrów, którzy uzyskali pełnoletność")
  //   ;
  // }

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
      'isVerified' => false,
      'dob' => $date
      ],

    );

    $output->writeln(sprintf("Znaleziono %d niepełnoletnich userów", count($pelnoletni)));

    // zmianiamy status na aktywny
    foreach ($pelnoletni as $pelno) {
      $pelno
        ->setIsVerified(true)
      ;
      $em->persist($pelno);
    }

    // zapisujemy w bazie
    $em->flush();

    $output->writeln(sprintf("Udało się zaktualizować %d userów", count($pelnoletni)));

    // $pelnoletni = $repo->createQueryBuilder('u')
    //   ->andWhere('u.dob = :today')
    //   ->setParameter('today', date('Y-m-d', strtotime("+18 years")))
    //   // ->andWhere('u.dob < :dzis')
    //   // ->setParameter('dzis', new \DateTime())
    //   ->getQuery()
    //   ->getResult();

    // $output->writeln(sprintf("Znaleziono %d niepełnoletnich userów", count($pelnoletni)));

    return 0;
  }
}