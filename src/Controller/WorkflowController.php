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
     * @Route("/{id}/check", name="workflow_backpack_check", methods={"GET","POST"})
     *
     * @param Backpack          $backpack
     * @param WorkflowBackpackManager $workflow
     *
     * @return Response
     *
     * @IsGranted("ROLE_USER")
     */
    public function checkBackpack(Backpack $backpack, WorkflowBackpackManager $workflow): Response
    {
        return $this->render('verif/workflow.html.twig', [
            'backpack' => $backpack,
        ]);
    }

    /**
     * @Route("/{id}/check/{transition}", name="workflow_backpack_check_apply_transition", methods={"GET","POST"})
     *
     * @param Backpack          $backpack
     * @param WorkflowBackpackManager $workflow
     *
     * @return Response
     *
     * @IsGranted("ROLE_USER")
     */
    public function checkApplyTransition(Backpack $backpack, WorkflowBackpackManager $workflow, string $transition): Response
    {
        $backpack->setContentState('Modification avec la transition : ' . $transition);

        $workflow->applyTransition($backpack, $transition, 'Modification effectuée par l\'administrateur');

        return $this->redirectToRoute('workflow_backpack_check', ['id' => $backpack->getId()]);
    }
    
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


    /**
     * @Route("/{id}/{transition}", name="workflow_backpack_apply_transition", methods={"GET","POST"})
     *
     * @param Request $request
     * @param Backpack $item
     * @param WorkflowBackpackManager $workflowBackpackManager
     * @param string $transition
     *
     * @return Response
     *
     * @IsGranted("ROLE_USER")
     */
    public function applyTransitionBackpack(Request $request, Backpack $item, WorkflowBackpackManager $workflowBackpackManager, string $transition): Response
    {
        if ($this->isCsrfTokenValid($transition . $item->getId(), $request->request->get('_token'))) {

            $content = $request->request->get($transition . '_content');

            $result = $workflowBackpackManager->applyTransition($item, $transition, $content);

            if ($result) {
                $this->addFlash(self::SUCCESS, 'Le changement d\'état est effectué');

                return $this->redirectToRoute('backpack_edit', ['id' => $item->getId()]);
            }
            $this->addFlash(self::DANGER, 'Le changement d\'état n\'a pas abouti. Les conditions ne sont pas remplies.');
        }

        return $this->redirectToRoute('backpack_edit', ['id' => $item->getId()]);
    }


}
