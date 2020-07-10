<?php

namespace App\Helper;

use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @author Emmanuel SAUVAGE <emmanuel.sauvage@live.fr>
 * @version 1.0.0
 */
class ParamsInServices
{
    CONST APPLICATION_NAME='application.name';
    CONST DIRECTORY_AVATAR= 'directory_avatar';
    CONST MAILER_NAME='mailer.name';
    CONST MAILER_MAIL='mailer.mail';
    CONST MAILER_PREFIXE='mailer.prefixe';
    CONST MAILER_SMTP_PASSWORD='mailer.smtp.password';
    CONST MAILER_SMTP_USERNAME='mailer.smtp.username';
    CONST MAILER_SMTP_HOST='mailer.smtp.host';
    CONST MAILER_SMTP_PORT='mailer.smtp.port';


    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * @var array $datas
     */
    private $datas=[];

    /**
     * ParamsInServices constructor.
     * @param ParameterBagInterface $params
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->datas=[
            self::APPLICATION_NAME,
            self::DIRECTORY_AVATAR,
            self::MAILER_NAME,
            self::MAILER_MAIL,
            self::MAILER_PREFIXE,
            self::MAILER_SMTP_PASSWORD,
            self::MAILER_SMTP_USERNAME,
            self::MAILER_SMTP_HOST,
            self::MAILER_SMTP_PORT,
        ];
    }

    /**
     * Récupère la valeur paramètre présente dans le fichiers config/services.yaml.
     * Utiliser les constantes présentes dans cette classe
     *
     * @param string $param_name
     * @return string
     * @throws ParameterNotFoundException if the parameter is not defined
     */
    public function get(string $param_name) :string
    {
        if(!in_array($param_name,$this->datas)){
            throw new \InvalidArgumentException('Ce paramètre est incconnu : '. $param_name);
        }
        return $this->params->get($param_name);
    }

}