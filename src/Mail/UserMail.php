<?php

declare(strict_types=1);

namespace App\Mail;

use App\Entity\User;

use function in_array;

class UserMail
{
    public const LOGIN = 'user/login';
    public const VALIDATE = 'user/validate';
    public const REGISTRATION = 'user/register';
    public const PASSWORDFORGET = 'user/password_forget';

    private $mail;

    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    public function send(User $user, string $context, string $subject): int
    {
        if (! in_array($context, [self::LOGIN, self::VALIDATE, self::REGISTRATION, self::PASSWORDFORGET])) {
            return -1;
        }

        $this->mail
            ->setUserTo($user)
            ->setContext($context)
            ->setSubject($subject)
            ->setParamsTwig(['user' => $user]);

        return $this->mail->send();
    }
}
