<?php

/*
 * This file is part of the AdminLTE-Bundle demo.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use App\Entity\User;
use App\Security\CurrentUser;
use KevinPapst\AdminLTEBundle\Event\NavbarUserEvent;
use KevinPapst\AdminLTEBundle\Event\ShowUserEvent;
use KevinPapst\AdminLTEBundle\Event\SidebarUserEvent;
use KevinPapst\AdminLTEBundle\Model\UserModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class NavbarUserSubscriber implements EventSubscriberInterface
{
    /**
     * @var CurrentUser
     */
    protected $currentUser;

    /**
     * @param Security $security
     */
    public function __construct(CurrentUser $currentUser)
    {
        $this->currentUser = $currentUser;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            NavbarUserEvent::class => ['onShowUser', 100],
            SidebarUserEvent::class => ['onShowUser', 100],
        ];
    }

    /**
     * @param ShowUserEvent $event
     */
    public function onShowUser(ShowUserEvent $event)
    {
        if (null === $this->currentUser->getUser()) {
            return;
        }

        /* @var $myUser User */
        $myUser = $this->currentUser->getUser();

        $user = new UserModel();
        $user
            ->setId($myUser->getId())
            ->setName($myUser->getName())
            ->setUsername($myUser->getName())
            ->setIsOnline(true)
            ->setTitle('')
            ->setAvatar($myUser->getAvatar())
            ->setMemberSince($myUser->getCreatedAt());

        $event->setShowLogoutLink(true);
        $event->setShowProfileLink(true);

        $event->setUser($user);
    }
}
