<?php


namespace App\Workflow\Transaction;


class TransitionGoToCheck extends TransitionAbstract
{
    public function getExplains(): array
    {
        return ['Vous pouvez trnsmettre ce porte-document au service documentation.'];
    }
}
