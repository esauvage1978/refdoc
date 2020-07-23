<?php

declare(strict_types=1);

namespace App\Dto;

class ProcessDto extends AbstractDto
{
    use TraitIsEnable;

    /** @var MProcessDto|null */
    private $mProcessDto;
    /** @var SubscriptionDto|null */
    private $subscriptionDto;

    public function getMProcessDto(): ?MProcessDto
    {
        return $this->mProcessDto;
    }

    public function setMProcessDto(?MProcessDto $mProcessDto): ProcessDto
    {
        $this->mProcessDto = $mProcessDto;

        return $this;
    }

    public function getSubscriptionDto(): ?SubscriptionDto
    {
        return $this->subscriptionDto;
    }

    public function setSubscriptionDto(?SubscriptionDto $subscriptionDto): ProcessDto
    {
        $this->subscriptionDto = $subscriptionDto;

        return $this;
    }
}
