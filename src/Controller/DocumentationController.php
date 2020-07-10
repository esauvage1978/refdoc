<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DocumentationController extends AbstractController
{
    /**
     * @Route("/documentation", name="documentation")
     */
    public function index()
    {
        //les fichiers sont à déposer dans public/doc
        $docs = [[
            'name' => 'Guide pour la recherche',
            'url' => '',
            'date' => ''
        ], [
            'name' => 'Guide du compte utilisateur',
            'url' => '',
            'date' => ''
        ]];

        return $this->render('documentation/index.html.twig', [
            'docs' => $docs,
        ]);
    }
}
