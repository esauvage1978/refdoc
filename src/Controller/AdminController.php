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
            ],
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
        ];

        $action_entries = [];

        return $this->render('admin/index.html.twig', [
            'general_entries' => $general_entries,
            'app_entries' => $app_entries,
            'action_entries' => $action_entries,
        ]);
    }
}
