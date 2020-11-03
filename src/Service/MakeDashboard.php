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


    private const ROUTE = 'route';
    private const ROUTE_OPTIONS = 'route_options';
    private const BG_COLOR = 'bgColor';
    private const FORE_COLOR = 'foreColor';
    private const TITLE = 'title';
    private const ICONE = 'icone';
    private const NBR = 'nbr';

    public const DRAFT = 'draft';
    public const MY_DRAFT_UPDATABLE = 'mydraft_updatable';
    public const DRAFT_UPDATABLE = 'draft_updatable';
    public const TO_VALIDATE = 'to_validate';

    public function getData(string $data)
    {
        $datas = [
            self::DRAFT => [
                self::ROUTE => 'backpacks_' . self::DRAFT,
                self::ROUTE_OPTIONS => null,
                self::BG_COLOR => WorkflowData::getBGColorOfState(WorkflowData::STATE_DRAFT),
                self::FORE_COLOR => WorkflowData::getForeColorOfState(WorkflowData::STATE_DRAFT),
                self::ICONE => WorkflowData::getIconOfState(WorkflowData::STATE_DRAFT),
                self::TITLE => 'Les brouillons',
                self::NBR => $this->counter->get(BackpackMakerDto::DRAFT),
            ],
            self::DRAFT_UPDATABLE => [
                self::ROUTE => 'backpacks_' . self::DRAFT_UPDATABLE,
                self::ROUTE_OPTIONS => null,
                self::BG_COLOR => WorkflowData::getBGColorOfState(WorkflowData::STATE_DRAFT),
                self::FORE_COLOR => WorkflowData::getForeColorOfState(WorkflowData::STATE_DRAFT),
                self::ICONE => WorkflowData::getIconOfState(WorkflowData::STATE_DRAFT),
                self::TITLE => 'Les brouillons modifiables',
                self::NBR => $this->counter->get(BackpackMakerDto::DRAFT_UPDATABLE),
            ],
            self::MY_DRAFT_UPDATABLE => [
                self::ROUTE => 'backpacks_' . self::MY_DRAFT_UPDATABLE,
                self::ROUTE_OPTIONS => null,
                self::BG_COLOR => WorkflowData::getBGColorOfState(WorkflowData::STATE_DRAFT),
                self::FORE_COLOR => WorkflowData::getForeColorOfState(WorkflowData::STATE_DRAFT),
                self::ICONE => WorkflowData::getIconOfState(WorkflowData::STATE_DRAFT),
                self::TITLE => 'Les brouillons modifiables',
                self::NBR => $this->counter->get(BackpackMakerDto::MY_DRAFT_UPDATABLE),
            ],
            self::TO_VALIDATE => [
                self::ROUTE => 'backpacks_' . self::TO_VALIDATE,
                self::ROUTE_OPTIONS => null,
                self::BG_COLOR => WorkflowData::getBGColorOfState(WorkflowData::STATE_TO_VALIDATE),
                self::FORE_COLOR => WorkflowData::getForeColorOfState(WorkflowData::STATE_TO_VALIDATE),
                self::ICONE => WorkflowData::getIconOfState(WorkflowData::STATE_TO_VALIDATE),
                self::TITLE => 'A valider par la hiérarchie',
                self::NBR => $this->counter->get(BackpackMakerDto::TO_VALIDATE),
            ],            
        ];


        return $this->getArray($datas[$data]);
    }

    public function __construct(
        BackpackDtoRepository $backpackDtoRepository,
        User $user
    ) {
        $this->counter = new BackpackCounter($backpackDtoRepository, $user);
    }

    private function getArray($datas)
    {
        $ib = new WidgetInfoBox();

        return $ib
            ->setRoute($datas[self::ROUTE])
            ->setRouteOptions($datas[self::ROUTE_OPTIONS])
            ->setBgColor($datas[self::BG_COLOR])
            ->setForeColor($datas[self::FORE_COLOR])
            ->setIcone($datas[self::ICONE])
            ->setTitle($datas[self::TITLE])
            ->setData($datas[self::NBR])
            ->createArray();
    }


    public function getPublished()
    {
        $state = WorkflowData::STATE_PUBLISHED;
        return $this->getArray(
                'backpacks_' . $state,
                ['state', $state],
                WorkflowData::getBGColorOfState(WorkflowData::STATE_PUBLISHED),
                WorkflowData::getForeColorOfState(WorkflowData::STATE_PUBLISHED),
                WorkflowData::getNameOfState($state),
                $this->counter->get(BackpackMakerDto::PUBLISHED)
            );
    }

    public function getNews()
    {
        $state = WorkflowData::STATE_PUBLISHED;
        return $this->getArray(
                'backpacks_news',
                ['state', $state],
                'fuchsia',
                'white',
                'Les nouveautés',
                $this->counter->get(BackpackMakerDto::NEWS)
            );
    }

    public function getArchived()
    {
        $state = WorkflowData::STATE_ARCHIVED;
        return $this->getArray(
                'backpacks_' . $state,
                ['state', $state],
                WorkflowData::getBGColorOfState(WorkflowData::STATE_ARCHIVED),
                WorkflowData::getForeColorOfState(WorkflowData::STATE_ARCHIVED),
                WorkflowData::getNameOfState($state),
                $this->counter->get(BackpackMakerDto::ARCHIVED)
            );
    }

    public function getAbandonned()
    {
        $state = WorkflowData::STATE_ABANDONNED;
        return $this->getArray(
                'backpacks_' . $state,
                ['state', $state],
                WorkflowData::getBGColorOfState(WorkflowData::STATE_ABANDONNED),
                WorkflowData::getForeColorOfState(WorkflowData::STATE_ABANDONNED),
                WorkflowData::getNameOfState($state),
                $this->counter->get(BackpackMakerDto::ABANDONNED)
            );
    }
}
