<?php

namespace App\Command;

use App\Entity\User;
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
    // $em = $this->entityManager;
    // $repo = $em->getRepository(User::class);

    // $pelnoletni = $repo->createQueryBuilder('u')
    //   ->andWhere('u.dob = :today')
    //   ->setParameter('today', date('Y-m-d', strtotime("+18 years")))
    //   // ->andWhere('u.dob < :dzis')
    //   // ->setParameter('dzis', new \DateTime())
    //   ->getQuery()
    //   ->getResult();

    // $output->writeln(sprintf("Znaleziono %d pełnoletnich userów", count($pelnoletni)));

    $output->writeln("Dzień dobry");

  }
}