<?php

namespace App\Twig;

use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
  
  public function getFilters()
  {
      return [
        new TwigFilter('expireDOB', [
          $this, 'expireDOB'
          ]),
      ];
  }

  public function expireDOB(\DateTime $dob)
  {
    $now = new \DateTime('now');
    $difference = $now->diff($dob);

    // funkcja kontrolna do sprawdzenie wieku
    //return $difference->format('%y lat, %m miesięcy, %d dni.');

    // pełnoletni +1/
    if ($difference->format("%y") >= 18) {
      if ($difference->format("%m") >= 0){
        if ($difference->format("%d") > 0)
        return "+18";
      }
    }

    // userzy którym został ostatni rok
    if (($difference->format("%y") == 17)){
      $dzisiaj = new DateTime(date("Y-m-d"));
      $pelnoletni = $dob->modify('+18 years');
      $interval = $dzisiaj->diff($pelnoletni);
      return "za " . $interval->d . " dni";

    }

    // userzy którzy mają 16 lat i mniej lub mniej niż 17
    if (($difference->format("%y") < 17)){
      $dzisiaj = new DateTime(date("Y-m-d"));
      $pelnoletni = $dob->modify('+18 years');
      $interval = $dzisiaj->diff($pelnoletni);
      return "za " . $interval->y . " lat i " . $interval->d . " dni";

    }

    // w dniu dzisiejszym mają urodziny
    if (($difference->format("%y") == 18) && ($difference->format("%m") == 0) && ($difference->format("%d") == 0)) { 
      return "dziś";

    }

    #########################
    // $dzisiaj = new DateTime(date("Y-m-d"));

    // // tworzy błąd bo dodaje 18lat 
    // $pelnoletni = $dob->modify('+18 years');

    // $interval = $dzisiaj->diff($pelnoletni);

    // // powyżej 18 lat
    // if (intval($interval->y) > 18){
    //   return "+18";
    // }

    // // mniej niż rok
    // if (intval($interval->y) == 0){
    //   return "za " . $interval->d . " dni";
    // }

    // // poniżej 17 lat
    // return "za " . $interval->y . " lat i " . $interval->d . " dni";

  }
}