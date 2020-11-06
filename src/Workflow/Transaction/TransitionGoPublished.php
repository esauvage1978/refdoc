<?php


namespace App\Workflow\Transaction;


class TransitionGoPublished extends TransitionAbstract
{
    public function getExplains(): array
    {
        return ['Vous pouvez publier ce porte-document.'];
    }
}
