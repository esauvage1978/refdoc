<?php

namespace App\Entity;

use App\Repository\MPSubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MPSubscriptionRepository::class)
 */
class MPSubscription implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsEnable;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="mPSubscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=MProcessus::class, inversedBy="mPSubscriptions")
     */
    private $mProcessus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsEnable(): ?bool
    {
        return $this->IsEnable;
    }

    public function setIsEnable(bool $IsEnable): self
    {
        $this->IsEnable = $IsEnable;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMProcessus(): ?MProcessus
    {
        return $this->mProcessus;
    }

    public function setMProcessus(?MProcessus $mProcessus): self
    {
        $this->mProcessus = $mProcessus;

        return $this;
    }
}
