<?php


namespace App\Workflow\Transaction;


class TransitionGoToResume  extends TransitionAbstract
{

    public function getExplains(): array
    {
        return
            [
                'Ce porte-document doit être repris par l\'émetteur.'
            ];
    }

    public function check()
    {
        $this->checkAll();
    }

}