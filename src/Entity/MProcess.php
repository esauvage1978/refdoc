<?php

namespace App\Entity;

use App\Repository\MProcessRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MProcessRepository::class)
 */
class MProcess implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEnable;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $ref;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="mProcessValidators")
     * @ORM\JoinTable("mprocessvalidators_user")
     */
    private $validators;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="mProcessContributors")
     * @ORM\JoinTable("mprocesscontributors_user")
     */
    private $contributors;

    /**
     * @ORM\OneToMany(targetEntity=Subscription::class, mappedBy="mProcess")
     */
    private $subscriptions;

    /**
     * @ORM\OneToMany(targetEntity=Process::class, mappedBy="mProcess")
     */
    private $processes;

    public function __construct()
    {
        $this->validators = new ArrayCollection();
        $this->contributors = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->processes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsEnable(): ?bool
    {
        return $this->isEnable;
    }

    public function setIsEnable(bool $isEnable): self
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getValidators(): Collection
    {
        return $this->validators;
    }

    public function addValidator(User $validator): self
    {
        if (!$this->validators->contains($validator)) {
            $this->validators[] = $validator;
        }

        return $this;
    }

    public function removeValidator(User $validator): self
    {
        if ($this->validators->contains($validator)) {
            $this->validators->removeElement($validator);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getContributors(): Collection
    {
        return $this->contributors;
    }

    public function addContributor(User $contributor): self
    {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors[] = $contributor;
        }

        return $this;
    }

    public function removeContributor(User $contributor): self
    {
        if ($this->contributors->contains($contributor)) {
            $this->contributors->removeElement($contributor);
        }

        return $this;
    }

    /**
     * @return Collection|Subscription[]
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Subscription $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions[] = $subscription;
            $subscription->setMProcess($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): self
    {
        if ($this->subscriptions->contains($subscription)) {
            $this->subscriptions->removeElement($subscription);
            // set the owning side to null (unless already changed)
            if ($subscription->getMProcess() === $this) {
                $subscription->setMProcess(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Process[]
     */
    public function getProcesses(): Collection
    {
        return $this->processes;
    }

    public function addProcess(Process $process): self
    {
        if (!$this->processes->contains($process)) {
            $this->processes[] = $process;
            $process->setMProcess($this);
        }

        return $this;
    }

    public function removeProcess(Process $process): self
    {
        if ($this->processes->contains($process)) {
            $this->processes->removeElement($process);
            // set the owning side to null (unless already changed)
            if ($process->getMProcess() === $this) {
                $process->setMProcess(null);
            }
        }

        return $this;
    }


    public function getFullName(): ?string
    {
        return $this->getRef() . ' - ' . $this->getName();
    }
}
