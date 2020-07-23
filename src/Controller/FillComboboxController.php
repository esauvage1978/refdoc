<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProcessRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FillComboboxController extends AbstractGController
{
    /**
     * @Route("/ajax/getgrouping", name="ajax_fill_combobox_grouping", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function AjaxGetDir1(Request $request, ProcessRepository $repository): Response
    {
        $data = null;
        if ($request->request->has('id')) {
            $data = $request->request->get('id');
        }

        if ($request->isXmlHttpRequest()) {
            return $this->json(
                $repository->findAllFillComboboxGrouping(
                    $data
                ),200
            );
        }

        return new Response("Ce n'est pas une requête Ajax");
    }
}
