<?php


namespace App\Workflow;


class WorkflowData
{
    const STATE_DRAFT = 'draft';
    const STATE_ABANDONNED = 'abandonned';
    const STATE_PUBLISHED = 'published';
    const STATE_ARCHIVED = 'archived';


    const TRANSITION_TO_PUBLISH = 'toPublish';
    const TRANSITION_TO_ABANDONNE = 'toAbandonne';
    const TRANSITION_TO_ARCHIVE = 'toArchive';
    const TRANSITION_TO_DRAFT = 'toTheDraft';

    private const NAME = 'name';
    private const ICON = 'icon';
    private const TITLE_MAIL = 'title_mail';
    private const COLOR = 'color';
    private const TRANSITIONS = 'transitions';

    private static function getStates(): array
    {
        return [
            self::STATE_DRAFT =>
                [
                    self::NAME => ' Brouillon',
                    self::ICON => '<i class="fab fa-firstdraft text-info"></i>',
                    self::TITLE_MAIL => ' Un porte-document est passé à l\'état brouillon',
                    self::COLOR => '#beebff',
                    self::TRANSITIONS => [
                        self::TRANSITION_TO_PUBLISH,
                        self::TRANSITION_TO_ABANDONNE,
                        self::TRANSITION_TO_ARCHIVE
                    ]
                ],
            self::STATE_PUBLISHED =>
                [
                    self::NAME => ' Publié',
                    self::ICON => '<i class="fab fa-product-hunt text-success"></i>',
                    self::TITLE_MAIL => ' Un porte-document est publié',
                    self::COLOR => '#d4edda',
                    self::TRANSITIONS => [
                        self::TRANSITION_TO_DRAFT,
                        self::TRANSITION_TO_ARCHIVE,
                        self::TRANSITION_TO_ABANDONNE
                    ]
                ],
            self::STATE_ABANDONNED =>
                [
                    self::NAME => ' Abandonné',
                    self::ICON => '<i class="far fa-trash-alt text-danger"></i>',
                    self::TITLE_MAIL => ' Un porte-document est abandonné',
                    self::COLOR => '#f8d7da',
                    self::TRANSITIONS => [
                        self::TRANSITION_TO_DRAFT
                    ]
                ],
            self::STATE_ARCHIVED =>
                [
                    self::NAME => ' Archivé',
                    self::ICON => '<i class="fas fa-archive text-warning"></i>',
                    self::TITLE_MAIL => ' Un porte-document est archivé',
                    self::COLOR => '#fff3cd',
                    self::TRANSITIONS => [
                        self::TRANSITION_TO_ABANDONNE,
                        self::TRANSITION_TO_DRAFT
                    ]
                ],
        ];
    }

    public function hasData(string $data): bool
    {
        return self::hasState($data) && self::hasTransition($data);
    }

    public static function hasState(string $data): bool
    {
        $datas = [
            self::STATE_DRAFT,
            self::STATE_ABANDONNED,
            self::STATE_PUBLISHED,
            self::STATE_ARCHIVED,
        ];

        if (in_array($data, $datas)) {
            return true;
        }
        return false;
    }

    public static function hasTransition(string $data): bool
    {
        $datas = [
            self::TRANSITION_TO_PUBLISH,
            self::TRANSITION_TO_ABANDONNE,
            self::TRANSITION_TO_ARCHIVE,
            self::TRANSITION_TO_DRAFT,
        ];

        if (in_array($data, $datas)) {
            return true;
        }
        return false;
    }

    private static function  getStatesValue($state, $data)
    {
        if (!self::hasState($state)) {
            throw new \InvalidArgumentException('cet état n\'existe pas');
        }
        return self::getStates()[$state][$data];
    }
    public static function getTransitionsForState($state)
    {
        return self::getStatesValue($state, self::TRANSITIONS);
    }

    public static function getNameOfState(string $state)
    {
        return self::getStatesValue($state, self::NAME);
    }

    public static function getIconOfState(string $state)
    {
        return self::getStatesValue($state, self::ICON);
    }

    public static function getTitleOfMail(string $state)
    {
        return self::getStatesValue($state, self::TITLE_MAIL);
    }

    public static function getShortNameOfState(string $state)
    {
        return self::getStatesValue($state, self::NAME);
    }

    public static function getColorOfState(string $state)
    {
        return self::getStatesValue($state, self::COLOR);
    }

    public static function getModalDataForTransition(string $transition)
    {
        if (!self::hasTransition($transition)) {
            throw new \InvalidArgumentException('Cette transition n\'existe pas');
        }
        $data = [
            'state' => '',
            'transition' => $transition,
            'titre' => '',
            'btn_label' => ''
        ];

        switch ($transition) {
            case self::TRANSITION_TO_DRAFT:
                $data['state'] = self::STATE_DRAFT;
                $data['titre'] = 'Remettre en brouillon';
                $data['btn_label'] = 'Basculer';
                break;
            case self::TRANSITION_TO_PUBLISH:
                $data['state'] = self::STATE_PUBLISHED;
                $data['titre'] = 'Publier de porte document';
                $data['btn_label'] = 'Publier';
                break;
            case self::TRANSITION_TO_ABANDONNE:
                $data['state'] = self::STATE_ABANDONNED;
                $data['titre'] = 'Abandonner l\'action';
                $data['btn_label'] = 'Abandonner';
                break;
            case self::TRANSITION_TO_ARCHIVE:
                $data['state'] = self::STATE_ARCHIVED;
                $data['titre'] = 'Archiver le porte document';
                $data['btn_label'] = 'Archiver';
                break;

        }

        return $data;
    }

}