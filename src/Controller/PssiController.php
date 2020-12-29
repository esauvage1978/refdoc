<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PssiController extends AbstractController
{
    /**
     * @Route("/pssi", name="pssi")
     */
    public function index(UserRepository $repo)
    {
        return $this->render('pssi/index.html.twig', 
        [
            'admins' => $repo->findAllForContactAdmin()
        ]);
    }


}
