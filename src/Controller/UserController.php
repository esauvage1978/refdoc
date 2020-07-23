<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Dto\ProcessDto;
use App\Dto\MProcessDto;
use App\Form\Admin\UserType;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Repository\ProcessRepository;
use App\Repository\MProcessRepository;
use App\Repository\ProcessDtoRepository;
use App\Repository\MProcessDtoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @route("/user")
 */
class UserController extends AbstractGController
{
    public const DOMAINE = 'user';

    public function __construct(
        UserRepository $repository,
        UserManager $manager
    ) {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->domaine = 'user';
    }

    /**
     * @Route("/", name="user_list", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function list()
    {
        return $this->listAction();
    }

    /**
     * @Route("/add", name="user_add", methods={"GET","POST"})
     */
    public function add(Request $request)
    {
        return $this->editAction($request, new User(), UserType::class, false);
    }

    /**
     * @Route("/{id}/permission", name="permission")
     */
    public function permission(User $user,MProcessDtoRepository $mProcessDtoRepository): Response
    {
        $dto_MP = new MProcessDto();

        $dto_MP->setIsEnable(MProcessDto::TRUE);
        $mps = $mProcessDtoRepository->findAllForDto($dto_MP);

        $datas= [
            'item' => $user,
            'mps' => $mps,
            'mps_direction' => $user->getMProcessDirValidators(),
            'mps_strategique' => $user->getMProcessPoleValidators(),
            'mps_contributor' => $user->getMProcessContributors(),
            'ps_validator' => $user->getProcessValidators(),
            'ps_contributor'=> $user->getProcessContributors()
        ];

        return $this->render('user/permission.html.twig', $datas);
    }
    /**
     * @Route("/{id}/permission/mp_dirvalidator", name="toogle_permission_mp_dirvalidatorn", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function toogle_permission_mp_dirvalidatorn(
        Request $request,
        User $user,
        MProcessRepository $mProcessRepository
    ): Response {

        return $this->toogle_permission(
            $user,
            $request->query->has('mp_id')?$request->query->get('mp_id'):'',
            'dirValidator',
            $mProcessRepository
        );
    }

    /**
     * @Route("/{id}/permission/mp_polevalidator", name="toogle_permission_mp_polevalidator", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function toogle_permission_mp_polevalidator(
        Request $request,
        User $user,
        MProcessRepository $mProcessRepository
    ): Response {

        return $this->toogle_permission(
            $user,
            $request->query->has('mp_id') ? $request->query->get('mp_id') : '',
            'poleValidator',
            $mProcessRepository
        );
    }
    /**
     * @Route("/{id}/permission/mp_contributor", name="toogle_permission_mp_contributor", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function toogle_permission_mp_contributor(
        Request $request,
        User $user,
        MProcessRepository $mProcessRepository
    ): Response {


        return $this->toogle_permission(
            $user,
            $request->query->has('mp_id') ? $request->query->get('mp_id') : '',
            'mp_contributor',
            $mProcessRepository
        );
    }


    /**
     * @Route("/{id}/permission/p_contributor", name="toogle_permission_p_contributor", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function toogle_permission_p_contributor(
        Request $request,
        User $user,
        ProcessRepository $processRepository
    ): Response {

        return $this->toogle_permission(
            $user,
            $request->query->has('p_id') ? $request->query->get('p_id') : '',
            'p_contributor',
            null,
            $processRepository
        );
    }


    /**
     * @Route("/{id}/permission/p_validator", name="toogle_permission_p_validator", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function toogle_permission_p_validator(
        Request $request,
        User $user,
        ProcessRepository $processRepository
    ): Response {

        return $this->toogle_permission(
            $user,
            $request->query->has('p_id') ? $request->query->get('p_id') : '',
            'p_validator',
            null,
            $processRepository
        );
    }

    private function toogle_permission(
        User $user,
        string $id,
        string $type,
        MProcessRepository $mProcessRepository = null,
        ProcessRepository $processRepository = null
    ): Response {
        if ($user === null) {
            return $this->json([
                'code' => 403,
                'message' => 'Utilisateur non connecté'
            ], 403);
        }

        switch ($type) {
            case 'dirValidator':
                $mp = $mProcessRepository->find($id);
                if ($user->getMProcessDirValidators()->contains($mp)) {
                    $user->removeMProcessDirValidator($mp);
                    $value = false;
                } else {
                    $user->addMProcessDirValidator($mp);
                    $value = true;
                }
                break;
            case 'poleValidator':
                $mp = $mProcessRepository->find($id);
                if ($user->getMProcessPoleValidators()->contains($mp)) {
                    $user->removeMProcessPoleValidator($mp);
                    $value = false;
                } else {
                    $user->addMProcessPoleValidator($mp);
                    $value = true;
                }
                break;
            case 'mp_contributor':
                $mp = $mProcessRepository->find($id);
                if ($user->getMProcessContributors()->contains($mp)) {
                    $user->removeMProcessContributor($mp);
                    $value = false;
                } else {
                    $user->addMProcessContributor($mp);
                    $value = true;
                }
                break;
            case 'p_contributor':
                $p = $processRepository->find($id);
                if ($user->getProcessContributors()->contains($p)) {
                    $user->removeProcessContributor($p);
                    $value = false;
                } else {
                    $user->addProcessContributor($p);
                    $value = true;
                }
                break;
            case 'p_validator':
                $p = $processRepository->find($id);
                if ($user->getProcessValidators()->contains($p)) {
                    $user->removeProcessValidator($p);
                    $value = false;
                } else {
                    $user->addProcessValidator($p);
                    $value = true;
                }
                break;
            }


        $this->manager->save($user);

        return $this->json([
            'code' => 200,
            'value' => $value,
            'message' => ($value ? 'Habillité' : 'Non habillité')
        ], 200);
    }

    /**
     * @Route("/{id}", name="user_del", methods={"DELETE"})
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function delete(Request $request, User $item)
    {
        return $this->deleteAction($request, $item);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(
        User $item,
        MProcessDtoRepository $mProcessDtoRepository,
        ProcessDtoRepository $processDtoRepository
    ): Response
    {

        return $this->render('user/show.html.twig', [
            'item' => $item,
            'mps' => $mProcessDtoRepository->findAllForDto((new MProcessDto)->setIsEnable(MProcessDto::TRUE)),
            'ps' => $processDtoRepository->findAllForDto((new ProcessDto)->setVisible(ProcessDto::TRUE))
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function edit(Request $request, User $item)
    {
        return $this->editAction($request, $item, UserType::class);
    }
}
