<?php

namespace App\Command;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class OfAgeCommand extends Command
{

  protected static $defaultName = 'app:of-age';

  
  private $entityManager;
  
  public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
  {
    
    $this->entityManager = $entityManager;
    $this->mailer = $mailer;
    
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

    // while ($row = $pelnoletni['email']) {
    //   $email = (new Email())
    //     ->from(new Address('no-reply@netinteractive.test', 'Hello www.netinteractive.test'))
    //     ->to($row->getEmail())
    //     ->subject('Dzień dobry')
    //     ->text('Witaj w systemie')
    //     ->html('<p>Witaj w systemie!</p>');

    //   $this->mailer->send($email);
    // }

    // zmianiamy status na aktywny
    foreach ($pelnoletni as $pelno) {
      $email = (new Email())
        ->from(new Address('no-reply@netinteractive.test', 'Hello www.netinteractive.test'))
        ->to($pelno->getEmail())
        ->subject('Dzień dobry')
        ->text('Witaj w systemie')
        ->html('<p>Witaj w systemie!</p>')
      ;

      $this->mailer->send($email);
      
      $pelno
        ->setIsVerified(true)
      ;
      $em->persist($pelno);
    }
    $output->writeln(sprintf("Wysłano wiadomość powitalna do %d nowych userów", count($pelnoletni)));


    // zapisujemy w bazie
    $em->flush();

    // komunikat o zmianie statusu
    $output->writeln(sprintf('<info>Zaktualizowano status %d userów</info>', count($pelnoletni)));

    return 0;
  }
}