<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
    )
    {
        return $this->render('home/index.html.twig', []);
    }

    /**
     * @return Response
     */
    public function searchFormAction(): Response
    {
        return $this->render('home/search-form.html.twig', []);
    }

    /**
     * @return Response
     */
    public function message(): Response
    {
        return $this->render('home/search-form.html.twig', []);
    }

}
