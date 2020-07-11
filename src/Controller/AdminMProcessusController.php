<?php

namespace App\Controller;

use App\Entity\MProcessus;
use App\Form\Admin\MProcessusType;
use App\Manager\MProcessusManager;
use App\Repository\MProcessusRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminMProcessusController
 * @package App\Controller
 */
class AdminMProcessusController extends AbstractGController
{
    public function __construct
    (
        MProcessusRepository $repository,
        MProcessusManager $manager
    )
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->domaine = 'admin_mprocessus';
    }

    /**
     * @Route("/admin/mprocessus", name="admin_mprocessus_list", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function list()
    {
        return $this->listAction();
    }

    /**
     * @Route("/admin/mprocessus/add", name="admin_mprocessus_add", methods={"GET","POST"})
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function add(Request $request)
    {
        return $this->editAction($request, new MProcessus(), MProcessusType::class,false);
    }

    /**
     * @Route("/admin/mprocessus/{id}", name="admin_mprocessus_del", methods={"DELETE"})
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function delete(Request $request, MProcessus $item)
    {
        return $this->deleteAction($request, $item);
    }

    /**
     * @Route("/admin/mprocessus/{id}", name="admin_mprocessus_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(Request $request, MProcessus $item)
    {
        return $this->showAction($request, $item);
    }


    /**
     * @Route("/admin/mprocessus/{id}/edit", name="admin_mprocessus_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_GESTIONNAIRE")
     */
    public function edit(Request $request, MProcessus $item)
    {
        return $this->editAction($request, $item, MProcessusType::class);
    }
}
