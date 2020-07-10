<?php

namespace App\EventSubscriber;

use App\Security\CurrentUser;
use App\Security\Role;
use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class KnpMenuBuilderSubscriber implements EventSubscriberInterface
{
    /**
     * @var CurrentUser
     */
    private $currentUser;

    /**
     * @var ItemInterface
     */
    private $menu;

    /**
     * @var KnpMenuEvent
     */
    private $event;

    public function __construct(CurrentUser $currentUser)
    {
        $this->currentUser = $currentUser;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KnpMenuEvent::class => ['onSetupMenu', 100],
        ];
    }

    public function onSetupMenu(KnpMenuEvent $event)
    {
        $this->event = $event;
        $this->menu = $this->event->getMenu();

        if ($this->currentUser->isAuthenticatedRemember() && Role::isUser($this->currentUser->getUser())) {
            $this->addHome();
            $this->addDashboard();
            $this->addProfil();
            $this->addAdmin();
            $this->addDoc();
            $this->addDeconnexion();
        } elseif ($this->currentUser->isAuthenticatedRemember()) {
            $this->addHome();
            $this->addProfil();
            $this->addDoc();
            $this->addConnexion();
        } else {
            $this->addHome();
            $this->addDoc();
            $this->addConnexion();
        }
    }

    private function addAdmin()
    {
        if (Role::isAdmin($this->currentUser->getUser())) {
            $this->menu->addChild('admin', [
                'route' => 'admin',
                'label' => 'Administration',
                'childOptions' => $this->event->getChildOptions()
            ])->setLabelAttribute('icon', 'fas fa-wrench');
        }
    }


    private function addDashboard()
    {
        $this->menu->addChild('dashboard', [
            'route' => 'dashboard',
            'label' => 'Tableau de bord',
            'childOptions' => $this->event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-tachometer-alt');
    }

    private function addDeconnexion()
    {
        $this->menu->addChild(
            'logout',
            ['route' => 'user_logout', 'label' => 'Déconnexion', 'childOptions' => $this->event->getChildOptions()]
        )->setLabelAttribute('icon', 'fas fa-sign-out-alt');
    }

    private function addDoc()
    {
        $this->menu->addChild('documentation', [
            'route' => 'documentation',
            'label' => 'Documentation',
            'childOptions' => $this->event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-book');
    }

    private function addConnexion()
    {
        $this->menu->addChild(
            'login',
            ['route' => 'user_login', 'label' => 'Connexion', 'childOptions' => $this->event->getChildOptions()]
        )->setLabelAttribute('icon', 'fas fa-sign-in-alt');
    }

    private function addHome()
    {
        $this->menu->addChild('home', [
            'route' => 'home',
            'label' => 'Page d\'accueil',
            'childOptions' => $this->event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-home');
    }

    private function addProfil()
    {
        $this->menu->addChild('profil', [
            'route' => 'profil',
            'label' => 'Votre compte',
            'childOptions' => $this->event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-user');
    }

}
