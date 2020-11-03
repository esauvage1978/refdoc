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

        $dash_options = [
            $md->getData(MakeDashboard::DRAFT),
            $md->getData(MakeDashboard::DRAFT_UPDATABLE),
            $md->getData(MakeDashboard::MY_DRAFT_UPDATABLE),
        ];
        $to_validate_options = [
            $md->getData(MakeDashboard::TO_VALIDATE),
        ];        
        
        //$md->getNews()
        return $this->render(
            'dashboard/index.html.twig',
            [
                'dash_options' => $dash_options,
                'to_validate_options' => $to_validate_options
            ]
        );
    }
}
