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
    $dzisiaj = new DateTime(date("Y-m-d"));

    $pelnoletni = $dob->modify('+18 years');

    $interval = $dzisiaj->diff($pelnoletni);

    // powyżej 18 lat
    if (intval($interval->y) > 18){
      return "+18";
    }

    // mniej niż rok
    if (intval($interval->y) < 17){
      return "za " . $interval->d . " dni";
    }

    // poniżej 17 lat
    return "za " . $interval->y . " lat i " . $interval->d . " dni";

  }
}