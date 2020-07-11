<?php

namespace App\Entity;

use App\Repository\MProcessusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MProcessusRepository::class)
 */
class MProcessus implements EntityInterface
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
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="MProcessusValidators")
     * @ORM\JoinTable("mprocessusvalidators_user")
     */
    private $validators;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="MProcessusContributors")
     * @ORM\JoinTable("mprocessuscontributors_user")
     */
    private $contributors;

    /**
     * @ORM\OneToMany(targetEntity=MPSubscription::class, mappedBy="mProcessus")
     */
    private $mPSubscriptions;

    public function __construct()
    {
        $this->validators = new ArrayCollection();
        $this->contributors = new ArrayCollection();
        $this->mPSubscriptions = new ArrayCollection();
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
     * @return Collection|MPSubscription[]
     */
    public function getMPSubscriptions(): Collection
    {
        return $this->mPSubscriptions;
    }

    public function addMPSubscription(MPSubscription $mPSubscription): self
    {
        if (!$this->mPSubscriptions->contains($mPSubscription)) {
            $this->mPSubscriptions[] = $mPSubscription;
            $mPSubscription->setMProcessus($this);
        }

        return $this;
    }

    public function removeMPSubscription(MPSubscription $mPSubscription): self
    {
        if ($this->mPSubscriptions->contains($mPSubscription)) {
            $this->mPSubscriptions->removeElement($mPSubscription);
            // set the owning side to null (unless already changed)
            if ($mPSubscription->getMProcessus() === $this) {
                $mPSubscription->setMProcessus(null);
            }
        }

        return $this;
    }
}
