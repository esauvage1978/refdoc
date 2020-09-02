<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/role")
 */
class RoleController extends AbstractController
{
    /**
     * @Route("/gestionnaire", name="role_gestionnaire")
     */
    public function gestionnaire(UserRepository $repo)
    {
        return $this->render('role/gestionnaire.html.twig', [
            'items' => $repo->findAllForContactGestionnaire(),
        ]);
    }

    /**
     * @Route("/administrateur", name="role_administrateur")
     */
    public function administrateur(UserRepository $repo)
    {
        return $this->render('role/administrateur.html.twig', [
            'items' => $repo->findAllForContactAdmin(),
        ]);
    }

    /**
     * @Route("/utilisateur", name="role_utilisateur")
     */
    public function utilisateur(UserRepository $repo)
    {
        return $this->render('role/utilisateur.html.twig', [
            'items' => $repo->findAllForContactUtilisateur(),
        ]);
    }

    /**
     * @Route("/isdoc", name="role_doc")
     */
    public function doc(UserRepository $repo)
    {
        return $this->render('role/isdoc.html.twig', [
            'items' => $repo->findAllForContactIsDoc(),
        ]);
    }

    /**
     * @Route("/isControl", name="role_control")
     */
    public function control(UserRepository $repo)
    {
        return $this->render('role/iscontrol.html.twig', [
            'items' => $repo->findAllForContactIsControl(),
        ]);
    }
}
