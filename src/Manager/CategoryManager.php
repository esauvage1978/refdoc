<?php

namespace App\Manager;

use App\Entity\EntityInterface;
use App\Entity\User;
use App\Security\CurrentUser;
use App\Validator\CategoryValidator;
use Doctrine\ORM\EntityManagerInterface;

class CategoryManager extends AbstractManager
{
    public function __construct(
        EntityManagerInterface $manager,
        CategoryValidator $validator
    ) {
        parent::__construct($manager, $validator);
    }

    public function initialise(EntityInterface $entity): void
    {
        /**
         * @var Category
         */
        $cat=$entity;
        if ($cat->getIcone()==null) {
            $cat->setIcone("far fa-sticky-note");
        }
        if ($cat->getBgcolor() == null) {
            $cat->setBgcolor("#ffffff");
        }
        if ($cat->getForecolor() == null) {
            $cat->setForecolor("#ff0000");
        }
    }
}
