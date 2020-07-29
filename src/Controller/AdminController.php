<?php

declare(strict_types=1);

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_USER")
     */
    public function index()
    {
        $general_entries = [
            [
                'name' => 'Utilisateur',
                'route' => 'user_list',
            ], [
                'name' => 'Informations générales',
                'route' => 'gpi_list'
            ]
        ];

        $app_entries = [
            [
                'name' => 'Macro processus',
                'route' => 'admin_mprocess_list',
            ],
            [
                'name' => 'Processus',
                'route' => 'admin_process_list',
            ],
            [
                'name' => 'Type de document',
                'route' => 'admin_category_list',
            ],
        ];

        $action_entries = [
            [
                'name' => 'Liste des administrateurs',
                'route' => 'role_administrateur',
            ],
            [
                'name' => 'Liste des gestionnaires',
                'route' => 'role_gestionnaire',
            ],
            [
                'name' => 'Liste des utilisateurs',
                'route' => 'role_utilisateur',
            ],
        ];


        return $this->render('admin/index.html.twig', [
            'general_entries' => $general_entries,
            'app_entries' => $app_entries,
            'action_entries' => $action_entries,
        ]);
    }
}
