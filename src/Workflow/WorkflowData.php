<?php


namespace App\Workflow;


class WorkflowData
{
    const WORKFLOW_ALL = 'wkf_all';
    const WORKFLOW_WITHOUT_CONTROLCHECK = 'wkf_without_controlcheck';
    const WORKFLOW_WITHOUT_CONTROL = 'wkf_without_control';
    const WORKFLOW_WITHOUT_CHECK = 'wkf_without_check';

    const WORKFLOW_IS_SAME = 'same';


    const STATE_DRAFT = 'draft';
    const STATE_TO_VALIDATE = 'toValidate';
    const STATE_TO_CONTROL = 'toControl';
    const STATE_TO_CHECK = 'ToCheck';
    const STATE_PUBLISHED = 'published';
    const STATE_TO_REVISE = 'toRevise';
    const STATE_IN_REVIEW = 'inReview';
    const STATE_TO_RESUME = 'toResume';
    const STATE_ARCHIVED = 'archived';
    const STATE_ABANDONNED = 'abandonned';


    const TRANSITION_GO_TO_VALIDATE = 'goToValidate';
    const TRANSITION_GO_TO_CONTROL = 'goToControl';
    const TRANSITION_GO_TO_CHECK = 'goToCheck';
    const TRANSITION_GO_PUBLISHED = 'goPublished';
    const TRANSITION_GO_TO_REVISE = 'goToRevise';
    const TRANSITION_GO_IN_REVIEW = 'goInReview';
    const TRANSITION_GO_TO_RESUME = 'goToResume';
    const TRANSITION_GO_ABANDONNED = 'goAbandonned';
    const TRANSITION_GO_ARCHIVED = 'goArchived';

    private const NAME = 'name';
    private const ICON = 'icon';
    private const TITLE_MAIL = 'title_mail';
    private const BGCOLOR = 'bgcolor';
    private const FORECOLOR = 'forecolor';
    private const TRANSITIONS = 'transitions';

    private static function getStates(): array
    {
        return [
            self::STATE_DRAFT =>
            [
                self::NAME => ' Brouillon',
                self::ICON => 'fab fa-firstdraft',
                self::TITLE_MAIL => ' Un porte-document est passé à l\'état brouillon',
                self::BGCOLOR => '#440155',
                self::FORECOLOR => '#ffffff',
                self::TRANSITIONS => [
                    self::WORKFLOW_IS_SAME => [
                        self::TRANSITION_GO_TO_VALIDATE,
                        self::TRANSITION_GO_ABANDONNED
                    ]
                ]
            ],
            self::STATE_TO_VALIDATE =>
            [
                self::NAME => ' A valider',
                self::ICON => 'fas fa-stamp',
                self::TITLE_MAIL => ' Un porte-document est à valider par les responsables hiérarchiques',
                self::BGCOLOR => '#5b0570',
                self::FORECOLOR => '#ffffff',
                self::TRANSITIONS => [
                    self::WORKFLOW_ALL => [
                        self::TRANSITION_GO_TO_CONTROL,
                        self::TRANSITION_GO_TO_RESUME,
                        self::TRANSITION_GO_ABANDONNED
                    ],
                    self::WORKFLOW_WITHOUT_CONTROLCHECK => [
                        self::TRANSITION_GO_PUBLISHED,
                        self::TRANSITION_GO_TO_RESUME,
                        self::TRANSITION_GO_ABANDONNED
                    ],
                    self::WORKFLOW_WITHOUT_CONTROL => [
                        self::TRANSITION_GO_TO_CHECK,
                        self::TRANSITION_GO_TO_RESUME,
                        self::TRANSITION_GO_ABANDONNED
                    ],
                    self::WORKFLOW_WITHOUT_CHECK => [
                        self::TRANSITION_GO_TO_CONTROL,
                        self::TRANSITION_GO_TO_RESUME,
                        self::TRANSITION_GO_ABANDONNED
                    ],
                ]
            ],
            self::STATE_TO_CONTROL =>
            [
                self::NAME => ' A contrôler',
                self::ICON => '<i class="fab fa-product-hunt text-success"></i>',
                self::TITLE_MAIL => ' Un porte-document est à valider par le service contrôle',
                self::BGCOLOR => '#794A8D',
                self::FORECOLOR => '#ffffff',
                self::TRANSITIONS => [
                    self::WORKFLOW_ALL => [
                        self::TRANSITION_GO_TO_CHECK,
                        self::TRANSITION_GO_TO_RESUME,
                        self::TRANSITION_GO_ABANDONNED
                    ],
                    self::WORKFLOW_WITHOUT_CONTROLCHECK => [
                        self::TRANSITION_GO_ABANDONNED
                    ],
                    self::WORKFLOW_WITHOUT_CONTROL => [
                        self::TRANSITION_GO_ABANDONNED
                    ],
                    self::WORKFLOW_WITHOUT_CHECK => [
                        self::TRANSITION_GO_PUBLISHED,
                        self::TRANSITION_GO_TO_RESUME,
                        self::TRANSITION_GO_ABANDONNED
                    ],

                ]
            ],
            self::STATE_TO_CHECK =>
            [
                self::NAME => ' A vérifier',
                self::ICON => '<i class="fab fa-product-hunt text-success"></i>',
                self::TITLE_MAIL => ' Un porte-document est à valider par le service documentation',
                self::BGCOLOR => '#9974AA',
                self::FORECOLOR => '#ffffff',
                self::TRANSITIONS => [
                    self::WORKFLOW_ALL => [
                        self::TRANSITION_GO_PUBLISHED,
                        self::TRANSITION_GO_TO_RESUME,
                        self::TRANSITION_GO_ABANDONNED
                    ],
                    self::WORKFLOW_WITHOUT_CONTROLCHECK => [
                        self::TRANSITION_GO_ABANDONNED
                    ],
                    self::WORKFLOW_WITHOUT_CONTROL => [
                        self::TRANSITION_GO_PUBLISHED,
                        self::TRANSITION_GO_TO_RESUME,
                        self::TRANSITION_GO_ABANDONNED
                    ],
                    self::WORKFLOW_WITHOUT_CHECK => [
                        self::TRANSITION_GO_ABANDONNED
                    ],
                ]
            ],
            self::STATE_PUBLISHED =>
            [
                self::NAME => ' Publié',
                self::ICON => '<i class="fab fa-product-hunt text-success"></i>',
                self::TITLE_MAIL => ' Un porte-document est publié',
                self::BGCOLOR => '#297B48',
                self::FORECOLOR => '#ffffff',
                self::TRANSITIONS => [
                    self::WORKFLOW_IS_SAME => [
                        self::TRANSITION_GO_TO_REVISE,
                        self::TRANSITION_GO_ARCHIVED,
                        self::TRANSITION_GO_ABANDONNED
                    ]
                ]
            ],
            self::STATE_TO_REVISE =>
            [
                self::NAME => ' A révision',
                self::ICON => '<i class="fab fa-product-hunt text-success"></i>',
                self::TITLE_MAIL => ' Un porte-document est à réviser',
                self::BGCOLOR => '#49D96A',
                self::FORECOLOR => '#ffffff',
                self::TRANSITIONS => [
                    self::WORKFLOW_IS_SAME => [
                        self::TRANSITION_GO_TO_RESUME,
                        self::TRANSITION_GO_ARCHIVED,
                        self::TRANSITION_GO_ABANDONNED
                    ]
                ]
            ],
            self::STATE_ABANDONNED =>
            [
                self::NAME => ' Abandonné',
                self::ICON => '<i class="far fa-trash-alt text-danger"></i>',
                self::TITLE_MAIL => ' Un porte-document est abandonné',
                self::BGCOLOR => '#AA0C0C',
                self::FORECOLOR => '#ffffff',
                self::TRANSITIONS => [
                    self::WORKFLOW_IS_SAME => [
                        self::TRANSITION_GO_TO_RESUME
                    ]
                ]
            ],
            self::STATE_TO_RESUME =>
            [
                self::NAME => ' A repprendre',
                self::ICON => '<i class="far fa-edit text-success"></i>',
                self::TITLE_MAIL => ' Un porte-document est à repprendre',
                self::BGCOLOR => '#5B2971',
                self::FORECOLOR => '#ffffff',
                self::TRANSITIONS => [
                    self::WORKFLOW_IS_SAME => [
                        self::TRANSITION_GO_TO_VALIDATE,
                        self::TRANSITION_GO_ABANDONNED
                    ]
                ]
            ],
            self::STATE_ARCHIVED =>
            [
                self::NAME => ' Archivé',
                self::ICON => '<i class="fas fa-archive text-warning"></i>',
                self::TITLE_MAIL => ' Un porte-document est archivé',
                self::BGCOLOR => '#003E17',
                self::FORECOLOR => '#ffffff',
                self::TRANSITIONS => [
                    self::WORKFLOW_IS_SAME => [
                        self::TRANSITION_GO_ABANDONNED,
                        self::TRANSITION_GO_TO_RESUME
                    ]
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
            self::STATE_TO_VALIDATE,
            self::STATE_TO_CONTROL,
            self::STATE_TO_CHECK,
            self::STATE_PUBLISHED,
            self::STATE_TO_REVISE,
            self::STATE_IN_REVIEW,
            self::STATE_TO_RESUME,
            self::STATE_ABANDONNED,
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
            self::TRANSITION_GO_TO_VALIDATE,
            self::TRANSITION_GO_TO_CONTROL,
            self::TRANSITION_GO_TO_CHECK,
            self::TRANSITION_GO_PUBLISHED,
            self::TRANSITION_GO_TO_REVISE,
            self::TRANSITION_GO_IN_REVIEW,
            self::TRANSITION_GO_ARCHIVED,
            self::TRANSITION_GO_ABANDONNED,
            self::TRANSITION_GO_TO_RESUME
        ];

        if (in_array($data, $datas)) {
            return true;
        }
        return false;
    }

    private static function  getStatesValue($state, $data)
    {
        if (!self::hasState($state)) {
            throw new \InvalidArgumentException('cet état n\'existe pas : ' . $state);
        }
        return self::getStates()[$state][$data];
    }
    private static function  getStatesValueForWorkfow($workflow, $state, $data)
    {
        if (!self::hasState($state)) {
            throw new \InvalidArgumentException('cet état n\'existe pas : ' . $state);
        }
        if (array_key_exists(self::WORKFLOW_IS_SAME,  self::getStates()[$state][$data])) {
            return self::getStates()[$state][$data][self::WORKFLOW_IS_SAME];
        } else {
            return self::getStates()[$state][$data][$workflow];
        }
    }
    public static function getTransitionsForState($workflow, $state)
    {
        return self::getStatesValueForWorkfow($workflow, $state, self::TRANSITIONS);
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

    public static function getBGColorOfState(string $state)
    {
        return self::getStatesValue($state, self::BGCOLOR);
    }
    public static function getForeColorOfState(string $state)
    {
        return self::getStatesValue($state, self::FORECOLOR);
    }
    public static function getModalDataForTransition(string $transition)
    {
        if (!self::hasTransition($transition)) {
            throw new \InvalidArgumentException('Cette transition n\'existe pas : ' . $transition);
        }
        $data = [
            'state' => '',
            'transition' => $transition,
            'titre' => '',
            'btn_label' => ''
        ];

        switch ($transition) {
            case self::TRANSITION_GO_TO_VALIDATE:
                $data['state'] = self::STATE_TO_VALIDATE;
                $data['titre'] = 'Mettre à la validation hiérarchique';
                $data['btn_label'] = 'A valider';
                break;
            case self::TRANSITION_GO_TO_CONTROL:
                $data['state'] = self::STATE_TO_CONTROL;
                $data['titre'] = 'Mettre à la validation du service contrôle';
                $data['btn_label'] = 'Contrôler';
                break;
            case self::TRANSITION_GO_TO_RESUME:
                $data['state'] = self::STATE_TO_RESUME;
                $data['titre'] = 'Retourner à l\'émetteur';
                $data['btn_label'] = 'Retourner';
                break;
            case self::TRANSITION_GO_TO_CHECK:
                $data['state'] = self::STATE_TO_CHECK;
                $data['titre'] = 'Vérifier la forme des documents';
                $data['btn_label'] = 'Vérifier';
                break;
            case self::TRANSITION_GO_PUBLISHED:
                $data['state'] = self::STATE_PUBLISHED;
                $data['titre'] = 'Publier le document';
                $data['btn_label'] = 'Publier';
                break;
            case self::TRANSITION_GO_ABANDONNED:
                $data['state'] = self::STATE_ABANDONNED;
                $data['titre'] = 'Abandonner le document';
                $data['btn_label'] = 'Abandonner';
                break;
            case self::TRANSITION_GO_ARCHIVED:
                $data['state'] = self::STATE_ARCHIVED;
                $data['titre'] = 'Archiver le document';
                $data['btn_label'] = 'Archiver';
                break;
        }

        return $data;
    }
}
