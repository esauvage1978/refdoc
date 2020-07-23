<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use InvalidArgumentException;

use function in_array;

final class Role
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_GESTIONNAIRE = 'ROLE_GESTIONNAIRE';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public static function hasData(string $data): bool
    {
        $datas = [
            self::ROLE_USER,
            self::ROLE_GESTIONNAIRE,
            self::ROLE_ADMIN,
        ];

        if (in_array($data, $datas)) {
            return true;
        }

        return false;
    }

    public static function checkData(string $data)
    {
        if (!Role::hasData($data)) {
            throw new InvalidArgumentException('Ce paramètre est incconnu : ' . $data);
        }

    }

    public static function getDatas(): array
    {
        return [
            'Utilisateur' => self::ROLE_USER,
            'Gestionnaire' => self::ROLE_GESTIONNAIRE,
            'Administrateur' => self::ROLE_ADMIN,
        ];
    }

    /**
     * Défini si l'utilisateur est administrateur
     */
    public static function isAdmin(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        if (in_array(self::ROLE_ADMIN, $user->getRoles())) {
            return true;
        }

        return false;
    }

    /**
     * Défini si l'utilisateur est gestionnaire
     */
    public static function isGestionnaire(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        return in_array(self::ROLE_GESTIONNAIRE, $user->getRoles()) or self::isAdmin($user);
    }

    /**
     * Défini si l'utilisateur a l'habilitation utilisateur
     */
    public static function isUser(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        if (self::hasData(self::ROLE_USER)) {
            return true;
        }

        return false;
    }
}
