<?php

declare(strict_types=1);

namespace App\Mail;

use App\Helper\ParamsInServices;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class MailerTransport
{
    /** @var EsmtpTransport */
    private $transport;

    /** @var ParamsInServices */
    private $paramsInServices;

    public function __construct(ParamsInServices $paramsInServices)
    {
        $this->paramsInServices = $paramsInServices;
    }

    public function getTransport()
    {
        $port=intval( $this->paramsInServices->get(ParamsInServices::ES_MAILER_SMTP_PORT));
        $this->transport = new EsmtpTransport(
            $this->paramsInServices->get(ParamsInServices::ES_MAILER_SMTP_HOST),
            $port
        );
        $this->transport->setUsername($this->paramsInServices->get(ParamsInServices::ES_MAILER_USER_NAME));
        $this->transport->setPassword($this->paramsInServices->get(ParamsInServices::ES_MAILER_USER_PASSWORD));

        return $this->transport;
    }
}
