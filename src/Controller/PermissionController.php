<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PermissionController extends AbstractController
{
    /**
     * @Route("/permission/{id}", name="permission")
     */
    public function permission(
        User $user
    )
    {
        return $this->render('user/permission.html.twig',
            $this->getPermission($user));
    }

    public function getPermission(
        User $user)
    {
        return [
            'item' => $user
        ];
    }

    /**
     * @Route("/permission/", name="my_permission")
     */
    public function myPermission(
        CurrentUser $currentUser
    )
    {
        return $this->render('profil/permission.html.twig',
            $this->getPermission($currentUser->getUser()));
    }

}
