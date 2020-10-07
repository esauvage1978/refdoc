<?php

declare(strict_types=1);

namespace App\Controller;

use DateTime;
use App\Dto\UserDto;
use App\Entity\User;
use App\Dto\ProcessDto;
use App\Entity\Process;
use App\Dto\MProcessDto;
use App\Entity\MProcess;
use App\Dto\SubscriptionDto;
use App\Entity\Subscription;
use App\Security\CurrentUser;
use App\Repository\UserRepository;
use App\Manager\SubscriptionManager;
use App\Repository\ProcessDtoRepository;
use App\Repository\MProcessDtoRepository;
use App\Repository\SubscriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubscriptionController extends AbstractController
{
    /** @var MProcessDtoRepository */
    private $MProcessDtoRepository;

    /** @var User */
    private $user;

    /** @var SubscriptionRepository */
    private $subscriptionRepository;

    /** @var ProcessDtoRepository */
    private $processDtoRepository;

    public function __construct(
        CurrentUser $currentUser,
        SubscriptionRepository $subscriptionRepository,
        MProcessDtoRepository $MProcessDtoRepository,
        ProcessDtoRepository $processDtoRepository
    ) {
        $this->MProcessDtoRepository = $MProcessDtoRepository;
        $this->user = $currentUser->getUser();
        $this->subscriptionRepository = $subscriptionRepository;
        $this->processDtoRepository = $processDtoRepository;
    }

    /**
     * @Route("/subscription", name="mySubscription")
     * @IsGranted("ROLE_USER")
     */
    public function mySubscription(): Response
    {
        return $this->render('subscription/list.html.twig', $this->getDatas($this->user));
    }

    /**
     * @Route("/subscription/{id}", name="subscription")
     * @IsGranted("ROLE_USER")
     */
    public function subscription(User $user): Response
    {
        return $this->render('subscription/list.html.twig', $this->getDatas($user,true));
    }

    private function getDatas(User $user, bool $admin=false): array
    {
        $dto_MP = new MProcessDto();
        $dto_P = new ProcessDto();
        $dtoU = new UserDto();
        $dtoS = new SubscriptionDto();

        $dto_MP->setIsEnable(MProcessDto::TRUE);
        $items = $this->MProcessDtoRepository->findAllForDto($dto_MP);

        $dtoU->setId($user->getId());
        $dtoS->setUserDto($dtoU);
        $dto_MP->setSubscriptionDto($dtoS);
        $abosMP = $this->MProcessDtoRepository->findAllForDto($dto_MP, MProcessDtoRepository::FILTRE_DTO_INIT_SUBSCRIPTION);

        $dto_P->setSubscriptionDto($dtoS);
        $abosP = $this->processDtoRepository->findAllForDto($dto_P, MProcessDtoRepository::FILTRE_DTO_INIT_SUBSCRIPTION);

        return [
            'items' => $items,
            'abosMP' => $abosMP,
            'abosP' => $abosP,
            'user' => $user,
            'admin'=>$admin
        ];
    }

    /**
     * @Route("/ajax/toogle_abonnement_mp/{id}", name="ajax_toogle_abonnement_mp", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function AjaxToogleMp(
        Request $request,
        MProcess $mProcess,
        UserRepository $userRepository,
        SubscriptionManager $subscriptionManager
        ): Response {

        if( $this->user===null) {
            return $this->json([
                'code'=>403,
                'message'=>'Utilisateur non connecté'],403);
        }


        if($request->query->has('u_id'))            {
            $user = $userRepository->find($request->query->get('u_id'));
        } else {
            $user = $this->user;
        }
       
        
        $s = $this->subscriptionRepository->findOneBy(['user' => $user, 'mProcess' => $mProcess]);
        if (empty($s)) {
            $s = new Subscription();
            $s
                ->setUser($user)
                ->setMProcess($mProcess)
                ->setIsEnable(true)
                ->setCreatedAt(new DateTime());
        } else {
            $s
                ->setIsEnable(!$s->getIsEnable())
                ->setModifyAt(new DateTime());

           
        }

        $subscriptionManager->save($s);

        return $this->json([
            'code' => 200,
            'value' => $s->getIsEnable(),
            'message' => ($s->getIsEnable()?'Abonné':'Désabonné')
        ], 200);
    }

    /**
     * @Route("/ajax/toogle_abonnement_p/{id}", name="ajax_toogle_abonnement_p", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function AjaxToogleP(
        Request $request,
        Process $process,
        UserRepository $userRepository,
        SubscriptionManager $subscriptionManager
    ): Response {

        if ($this->user === null) {
            return $this->json([
                'code' => 403,
                'message' => 'Utilisateur non connecté'
            ], 403);
        }


        if ($request->query->has('u_id')) {
            $user = $userRepository->find($request->query->get('u_id'));
        } else {
            $user = $this->user;
        }

           
        $s = $this->subscriptionRepository->findOneBy(['user' => $user, 'process' => $process]);
        $return = true;
        if (empty($s)) {
            $s = new Subscription();
            $s
                ->setUser($user)
                ->setProcess($process)
                ->setIsEnable(true)
                ->setCreatedAt(new DateTime());
        } else {
            $s
                ->setIsEnable(!$s->getIsEnable())
                ->setModifyAt(new DateTime());
        }

        $subscriptionManager->save($s);

        return $this->json([
            'code' => 200,
            'value'=> $s->getIsEnable(),
            'message' => ($s->getIsEnable() ? 'Abonné' : 'Désabonné')
        ], 200);
    }
}
