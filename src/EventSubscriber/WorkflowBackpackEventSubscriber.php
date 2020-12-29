<?php

namespace App\EventSubscriber;

use App\Workflow\WorkflowBackpackTransitionManager;
use App\Workflow\WorkflowData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\GuardEvent;

/**
 * Class ActionSubscriber.
 */
class WorkflowBackpackEventSubscriber implements EventSubscriberInterface
{


    public function __construct()
    {
    }

    /**
     * @param GuardEvent $event
     */
    public function onGuardGoToValidate(GuardEvent $event)
    {
        dump("onGuardGoToValidate");
        $this->onGuard($event, WorkflowData::TRANSITION_GO_TO_VALIDATE);
    }


    private function onGuard(GuardEvent $event, string $transition)
    {
        /** @var Action $action */
        $action = $event->getSubject();
        $workflowActionTransitionManager = new WorkflowBackpackTransitionManager(
            $event->getSubject(),
            $transition
        );

        if (!$workflowActionTransitionManager->can()) {
            $event->setBlocked(true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        dump("getSubscribedEvents");
        return [
            'workflow.action.guard.GoToValidate' => ['onGuardGoToValidate'],
        ];
    }
}
