<?php

namespace App\Service;

use App\Dto\BackpackDto;
use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\BackpackDtoRepository;
use App\Widget\WidgetInfoBox;
use App\Workflow\WorkflowData;

class MakeDashboard
{
    /**
     * @var BackpackCounter
     */
    private $counter;


    public function __construct(
        BackpackDtoRepository $backpackDtoRepository,
        User $user
    )
    {
        $this->counter = new BackpackCounter($backpackDtoRepository, $user);
    }

    private function getArray($route, $routeOptions, $color, $title, $nbr)
    {
        $ib = new WidgetInfoBox();

        return $ib
            ->setRoute($route)
            ->setRouteOptions($routeOptions)
            ->setColor($color)
            ->setIcone('fas fa-bezier-curve')
            ->setTitle($title)
            ->setData($nbr)
            ->createArray();

    }

    public function getDraft()
    {
        $state = WorkflowData::STATE_DRAFT;
        return $this->getArray
        (
            'backpacks_' . $state,
            null,
            'info',
            'Les brouillons',
            $this->counter->get(BackpackMakerDto::DRAFT)
        );
    }

    public function getMyDraftUpdatable()
    {
        $state = WorkflowData::STATE_DRAFT;
        return $this->getArray
        (
            'backpacks_mydraft_updatable',
            ['state', $state],
            'info',
            '<strong>Mes</strong> brouillons modifiables',
            $this->counter->get(BackpackMakerDto::MY_DRAFT_UPDATABLE)
        );
    }

    public function getDraftUpdatable()
    {
        $state = WorkflowData::STATE_DRAFT;
        return $this->getArray(
                'backpacks_draft_updatable',
                ['state', $state],
                'info',
                'Les brouillons modifiables',
                $this->counter->get(BackpackMakerDto::DRAFT_UPDATABLE)
            );
    }

    public function getPublished()
    {
        $state = WorkflowData::STATE_PUBLISHED;
        return $this->getArray
        (
            'backpacks_' . $state,
            ['state', $state],
            'success',
            WorkflowData::getNameOfState($state),
            $this->counter->get(BackpackMakerDto::PUBLISHED)
        );
    }

    public function getNews()
    {
        $state = WorkflowData::STATE_PUBLISHED;
        return $this->getArray
        (
            'backpacks_news',
            ['state', $state],
            'fuchsia',
            'Les nouveautés',
            $this->counter->get(BackpackMakerDto::NEWS)
        );
    }

    public function getArchived()
    {
        $state = WorkflowData::STATE_ARCHIVED;
        return $this->getArray
        (
            'backpacks_' . $state,
            ['state', $state],
            'warning',
            WorkflowData::getNameOfState($state),
            $this->counter->get(BackpackMakerDto::ARCHIVED)
        );
    }

    public function getAbandonned()
    {
        $state = WorkflowData::STATE_ABANDONNED;
        return $this->getArray
        (
            'backpacks_' . $state,
            ['state', $state],
            'danger',
            WorkflowData::getNameOfState($state),
            $this->counter->get(BackpackMakerDto::ABANDONNED)
        );
    }

    public function getHide()
    {
        return $this->getArray
        (
            'backpacks_hide',
            [],
            'black',
            'Masqué',
            $this->counter->get(BackpackMakerDto::HIDE)
        );
    }

}
