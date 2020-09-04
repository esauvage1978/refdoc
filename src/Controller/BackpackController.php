<?php

namespace App\Controller;

use App\Dto\BackpackDto;
use App\Dto\MProcessDto;
use App\Dto\UserDto;
use App\Entity\Backpack;
use App\Form\Backpack\BackpackNewType;
use App\Form\Backpack\BackpackType;
use App\Helper\ParamsInServices;
use App\Manager\BackpackManager;
use App\Repository\BackpackDtoRepository;
use App\Repository\BackpackRepository;
use App\Security\BackpackVoter;
use App\Security\CurrentUser;
use App\Security\Role;
use App\Service\BackpackMakerDto;
use App\Tree\BackpackTree;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ThematicController
 * @package App\Controller
 */
class BackpackController extends AbstractGController
{

    /**
     * @var BackpackMakerDto
     */
    private $backpackMakerDto;

    /**
     * @var ParamsInServices
     */
    private $paramsInServices;

    /**
     * @var BackpackDtoRepository
     */
    private $backpackDtoRepository;

    public function __construct(
        BackpackRepository $repository,
        backpackManager $manager,
        ParamsInServices $paramsInServices,
        CurrentUser $currentUser,
        BackpackDtoRepository $backpackDtoRepository
    ) {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->domaine = 'backpack';
        $this->paramsInServices = $paramsInServices;
        $this->backpackDtoRepository = $backpackDtoRepository;
        $this->backpackMakerDto = new BackpackMakerDto($currentUser->getUser());
    }

    /**
     * @Route("/backpack/add", name="backpack_add", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function add(Request $request)
    {
        $this->denyAccessUnlessGranted(BackpackVoter::CREATE, null);

        return $this->editAction($request, new Backpack(), BackpackNewType::class, false);
    }


    /**
     * @Route("/backpack/{id}/edit", name="backpack_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Backpack $item)
    {
        $this->denyAccessUnlessGranted(BackpackVoter::UPDATE, $item);
        $itemOld = clone ($item);
        $form = $this->createForm(BackpackType::class, $item);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($request);
            dump($item);
            if ($this->manager->save($item)) {
                $this->addFlash(self::SUCCESS, self::MSG_MODIFY);
                //$backpackHistory->compare($itemOld, $item);
            } else {
                $this->addFlash(self::DANGER, self::MSG_MODIFY_ERROR . $this->manager->getErrors($item));
            }
        }

        return $this->render('backpack/edit.html.twig', [
            'item' => $item,
            self::FORM => $form->createView(),
        ]);
    }

    /**
     * @Route("/backpack/{id}/history", name="backpack_history", methods={"GET","POST"})
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function history(Request $request, Backpack $item): Response
    {
        return $this->render('backpack/history.html.twig', [
            'item' => $item,
            'histories' => null
        ]);
    }

    /**
     * @Route("/", name="home", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function home(Request $request)
    {
        return $this->treeView($request, $this->backpackMakerDto->get(BackpackMakerDto::DRAFT));
    }

    /**
     * @Route("/backpacks/draft", name="backpacks_draft", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function state_draft(Request $request)
    {
        return $this->treeView($request, $this->backpackMakerDto->get(BackpackMakerDto::DRAFT));
    }


    /**
     * @Route("/backpacks/mydraft", name="backpacks_mydraft", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function state_mydraft(Request $request)
    {
        return $this->treeView($request, $this->backpackMakerDto->get(BackpackMakerDto::MY_DRAFT));
    }

    /**
     * @Route("/backpacks", name="backpacks", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function treeView(Request $request, BackpackDto $dto)
    {

        if ($dto->getVisible() === null && $dto->getHide() === null) {
            $dto->setData($request);
            if (!is_null($this->getUser()) && !Role::isGestionnaire($this->getUser())) {
                $dto->setUserDto((new UserDto())->setId($this->getUser()->getId()));
            }
        }

        if (null === $dto) {

            $items = null;
        } else {
            $items = $this->backpackDtoRepository->findAllForDto($dto, BackpackDtoRepository::FILTRE_DTO_INIT_TREE);
        }

        $renderArray = $dto->getData();

        $tree = new BackpackTree($this->container, $request, $this->paramsInServices);

        if (!is_null($dto->getId())) {
            $tree->setItem($this->repository->find($dto->getId()));
        }


        $tree
            ->initialise($items)
            ->setRoute('backpacks')
            ->setParameter($renderArray);

        if (!is_null($dto->getCurrentState())) {
            $tree->hideState();
        }

        count($items) <= $this->paramsInServices->get(ParamsInServices::ES_TREE_UNDEVELOPPED_NBR) && $tree->Developed();
        array_key_exists('underRubric', $renderArray) && $tree->hideUnderThematic();

        $renderArray = array_merge(
            $renderArray,
            [
                'items' => $tree->getTree(),
                'count' => $tree->getCountItems(),
                'item' => $tree->getItem()
            ]
        );

        return $this->render('backpack/tree.html.twig', $renderArray);
    }

    /**
     * @Route("/backpack/{id}", name="backpack_del", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Backpack $item)
    {
        $this->denyAccessUnlessGranted(BackpackVoter::DELETE, $item);

        $dto = new BackpackDto();
        $dto
            ->setCurrentState($item->getCurrentState())
            ->setMProcessDto((new MProcessDto())->setId($item->getMProcess()->getId()))
            ->setVisible(BackpackDto::TRUE);

        if ($this->isCsrfTokenValid('delete' . $item->getId(), $request->request->get('_token'))) {
            $this->addFlash(self::SUCCESS, self::MSG_DELETE);
            $this->manager->remove($item);
        }

        return $this->treeView($request, $dto);
    }
}
