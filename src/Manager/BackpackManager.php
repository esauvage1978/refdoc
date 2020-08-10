<?php

namespace App\Manager;

use App\Entity\Backpack;
use App\Entity\EntityInterface;
use App\Security\CurrentUser;
use App\Validator\BackpackValidator;
use App\Workflow\WorkflowData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class BackpackManager extends AbstractManager
{
    /**
     * @var CurrentUser
     */
    private $currentUser;

    public function __construct(
        EntityManagerInterface $manager,
        BackpackValidator $validator,
        CurrentUser $currentUser
    ) {
        parent::__construct($manager, $validator);
        $this->currentUser = $currentUser;
    }

    public function initialise(EntityInterface $entity): void
    {
        /**
         * @var Backpack $bp
         */
        $bp = $entity;


        if (empty($entity->getId())) {

            null !== $this->currentUser->getUser() ?? $bp->setOwner($this->currentUser->getUser());

            $bp->setCreatedAt(new \DateTime());
            
        } else {
            $bp->setUpdateAt(new \DateTime());
        }

        foreach ($bp->getBackpackLinks() as $backpackLink) {
            $backpackLink->setBackpack($bp);
        }

        foreach ($bp->getBackpackFiles() as $backpackFile) {
            $backpackFile->setBackpack($bp);
        }

        if ($bp->getProcess() !== null) {
            $bp->setMProcess($bp->getProcess()->getMProcess());
        }
    }
}
