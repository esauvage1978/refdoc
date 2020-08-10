<?php

namespace App\Controller;

use App\Controller\AbstractGController;
use App\Entity\Backpack;
use App\Repository\BackpackStateRepository;
use App\Workflow\WorkflowBackpackManager;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/workflow")
 */
class WorkflowController extends AbstractGController
{


    /**
     * @Route("/{id}/history", name="workflow_backpack_history", methods={"GET"})
     *
     * @param BackpackStateRepository $repository
     * @param Backpack $backpack
     *
     * @return Response
     *
     * @IsGranted("ROLE_USER")
     */
    public function showHistoryBackpack(): Response
    {
        return $this->render('backpack/workflowHistory.html.twig', [
            'items' => null
        ]);
    }


}
