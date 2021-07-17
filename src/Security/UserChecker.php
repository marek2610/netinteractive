<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
  public function checkPreAuth(UserInterface $user): void
  {
      if (!$user instanceof User) {
          return;
      }

      // brak kolumny isDeleted w encji User
      // if ($user->isDeleted()) {
      //     // the message passed to this exception is meant to be displayed to the user
      //     throw new CustomUserMessageAccountStatusException('Your user account no longer exists.');
      // }
  }
  
  public function checkPostAuth(UserInterface $user)
  {
    if (!$user instanceof User) {
      return;
    }

    // weryfikacja czy konto jest aktywne 
    if (!$user->isVerified()) {
      throw new LockedException();
    }
  }
}