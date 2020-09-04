<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\MakeDashboard;
use App\Repository\BackpackDtoRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     * @IsGranted("ROLE_USER")
     */
    public function index(BackpackDtoRepository $backpackDtoRepository)
    {
        $md = new MakeDashboard($backpackDtoRepository, $this->getUser());

        $options = [
            $md->getDraft(),
            $md->getMyDraft(),
        ];
        
        //$md->getNews()
        return $this->render(
            'dashboard/index.html.twig',
            ['options' => $options]
        );
    }
}
