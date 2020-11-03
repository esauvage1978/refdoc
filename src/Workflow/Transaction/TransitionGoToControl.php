<?php


namespace App\Workflow\Transaction;


class TransitionGoToControl  extends TransitionAbstract
{

    public function getExplains(): array
    {
        return
            [
                'Vous envoyez ce porte-document à la validation du service contrôle.'
            ];
    }

    public function check()
    {
        $this->checkAll();
    }

}