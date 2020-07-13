<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubscriptionRepository::class)
 */
class Subscription implements EntityInterface
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
     * @ORM\ManyToOne(targetEntity=MProcess::class, inversedBy="mPSubscriptions")
     */
    private $mProcess;

    /**
     * @ORM\ManyToOne(targetEntity=Process::class, inversedBy="subscriptions")
     */
    private $process;

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

    public function getMProcess(): ?MProcess
    {
        return $this->mProcess;
    }

    public function setMProcess(?MProcess $mProcess): self
    {
        $this->mProcess = $mProcess;

        return $this;
    }

    public function getProcess(): ?Process
    {
        return $this->process;
    }

    public function setProcess(?Process $process): self
    {
        $this->process = $process;

        return $this;
    }
}
