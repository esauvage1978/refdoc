<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\UserDto;
use App\Entity\User;
use App\Security\Role;
use App\Dto\MProcessDto;
use App\Repository\ProcessRepository;
use App\Repository\MProcessDtoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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

    /**
     * @Route("/ajax/getmp", name="ajax_fill_combobox_mp", methods={"GET","POST"})
     *
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function AjaxGetMP(Request $request, MProcessDtoRepository $mProcessDtoRepository): Response
    {
        $dto = new MProcessDto();
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $dto
            ->setForUpdate(MProcessDto::TRUE)
            ->setVisible(MProcessDto::TRUE);

        if (!Role::isGestionnaire($user)) {
            $dto->setUserDto((new UserDto())->setId($this->getUser()->getId()));
        }

        return $this->json([
            'code' => 200,
            'value' => $mProcessDtoRepository->findForCombobox($dto),
            'message' => 'données transmises'
        ], 200);
                
    }
}
