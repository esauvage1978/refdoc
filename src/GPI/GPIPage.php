<?php

namespace App\GPI;

final class GPIPage
{
    const ADMINISTRATION = 'administration';
    const BACKPACK_CREATE = 'backpack_add';
    const BACKPACK_EDIT = 'backpack_edit';
    const BACKPACK_COMMENT = 'backpack_comment_add';
    const BACKPACK_HISTORY = 'backpack_history';
    const BACKPACK_HISTORY_WORKFLOW = 'backpack_history_workflow';
    const BACKPACK_COMMENTS = 'backpack_comments';
    const DASHBOARD = 'dashboard';
    const DOCUMENTATION = 'documentation';
    const HOME = 'home';
    const PROFIL = 'profil';
    const SUBSCRIPTION = 'subscription';

    public static function getDatas(): array
    {
        return [
            'Abonnement' => self::SUBSCRIPTION,
            'Administration' => self::ADMINISTRATION,
            'Documentation' => self::DOCUMENTATION,
            'Page d\'accueil' => self::HOME,
            'Porte-document : Ajout d\'un commentaire' => self::BACKPACK_COMMENT,
            'Porte-document : création' => self::BACKPACK_CREATE,
            'Porte-document : Les commentaires' => self::BACKPACK_COMMENTS,
            'Porte-document : historique des modifications' => self::BACKPACK_HISTORY,
            'Porte-document : historique du workflow' => self::BACKPACK_HISTORY_WORKFLOW,
            'Porte-document : Modification' => self::BACKPACK_EDIT,
            'Profil' => self::PROFIL,
            'Tableau de bord' => self::DASHBOARD,
        ];
    }

    public static function getName($page)
    {
        self::checkData($page);
        return array_search($page,self::getDatas());
    }

    public static function hasData(string $data): bool
    {
        $datas = [
            self::HOME,
            self::DASHBOARD,
            self::BACKPACK_CREATE,
            self::BACKPACK_EDIT,
            self::BACKPACK_COMMENT,
            self::BACKPACK_HISTORY,
            self::BACKPACK_HISTORY_WORKFLOW,
            self::BACKPACK_COMMENTS,
            self::DOCUMENTATION,
            self::ADMINISTRATION,
            self::PROFIL,
            self::SUBSCRIPTION,
        ];

        if (in_array($data, $datas)) {
            return true;
        }
        return false;
    }

    public static function checkData($data)
    {
        if(!self::hasData($data)) {
            throw new \InvalidArgumentException('Ce paramètre n\'est pas présent !');
        }
    }
}