<?php

namespace App\Controller;

use App\Dto\RubricDto;
use App\Dto\UnderRubricDto;
use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\BackpackRepository;
use App\Repository\ProcessRepository;
use App\Repository\RubricDtoRepository;
use App\Repository\UnderRubricDtoRepository;
use App\Security\Role;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FillComboboxController extends AbstractGController
{


    /**
     * @Route("/ajax/getgrouping", name="ajax_fill_combobox_grouping", methods={"POST"})
     *
     * @return Response
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
                    $data)
            );
        }

        return new Response("Ce n'est pas une requête Ajax");
    }

}
