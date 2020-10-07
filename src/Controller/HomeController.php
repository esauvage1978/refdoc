<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/2", name="home2")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', []);
    }

    public function searchFormAction(): Response
    {
        return $this->render('home/search-form.html.twig', []);
    }

    public function message(): Response
    {
        return $this->render('home/search-form.html.twig', []);
    }
}
