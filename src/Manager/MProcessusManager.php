<?php

namespace App\Manager;

use App\Entity\EntityInterface;
use App\Validator\MProcessusValidator;
use Doctrine\ORM\EntityManagerInterface;

class MProcessusManager extends AbstractManager
{
    public function __construct(EntityManagerInterface $manager,MProcessusValidator $validator)
    {
        parent::__construct($manager,$validator);
    }

    public function initialise(EntityInterface $entity): void
    {
        if(empty($entity->getRef())) {
            $entity->setRef('000');
        }
    }
}
