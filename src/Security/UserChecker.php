<?php
declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Exception\AccountDisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->getEnabled()) {
            throw new AccountDisabledException('Your account is disabled.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        // Nothing to do here
    }
}
