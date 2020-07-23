<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;

final class CurrentUser
{
    /** @var User|null */
    private $user;

    /** @var Security */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
        $this->user = $security->getUser();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function isAuthenticatedRemember(): bool
    {
        return $this->security->isGranted('IS_AUTHENTICATED_REMEMBERED');
    }
}
