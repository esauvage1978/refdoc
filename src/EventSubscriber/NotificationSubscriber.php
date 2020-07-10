<?php

/*
 * This file is part of the AdminLTE-Bundle demo.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use App\Repository\BackpackDtoRepository;
use App\Security\CurrentUser;
use App\Security\Role;
use App\Service\BackpackCounter;
use App\Service\BackpackMakerDto;
use KevinPapst\AdminLTEBundle\Event\NotificationListEvent;
use KevinPapst\AdminLTEBundle\Helper\Constants;
use KevinPapst\AdminLTEBundle\Model\NotificationModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class NotificationSubscriber adds notification messages to the top bar.
 */
class NotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $auth;
    /**
     * @var CurrentUser
     */
    private $currentUser;



    /**
     * NotificationSubscriber constructor.
     * @param CurrentUser $currentUser
     */
    public function __construct(
        CurrentUser $currentUser
    )
    {
        $this->currentUser = $currentUser;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            NotificationListEvent::class => ['onNotifications', 100],
        ];
    }

    /**
     * @param NotificationListEvent $event
     */
    public function onNotifications(NotificationListEvent $event)
    {

        if (!$this->currentUser->isAuthenticatedRemember()) {
            $notification = new NotificationModel('Vous n\'êtes pas connecté !', Constants::TYPE_ERROR, 'fas fa-key');
            $notification->setId(1);
            $event->addNotification($notification);
            return;
        }


    }


}
