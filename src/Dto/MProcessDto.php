<?php

declare(strict_types=1);

namespace App\Dto;

class MProcessDto extends AbstractDto
{
    use TraitIsEnable;

    /** @var ProcessDto|null */
    private $processDto;

    /** @var SubscriptionDto|null */
    private $subscriptionDto;

    public function getProcessDto(): ?ProcessDto
    {
        return $this->processDto;
    }

    public function setProcessDto(ProcessDto $processDto): MProcessDto
    {
        $this->processDto = $processDto;

        return $this;
    }

    public function getSubscriptionDto(): ?SubscriptionDto
    {
        return $this->subscriptionDto;
    }

    public function setSubscriptionDto(?SubscriptionDto $subscriptionDto): MProcessDto
    {
        $this->subscriptionDto = $subscriptionDto;

        return $this;
    }
}
