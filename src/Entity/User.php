<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    private $username;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $emailValidated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailValidatedToken;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $forget_token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $loginAt;

    /**
     * @var ?string
     */
    private $plainPassword;

    /**
     * @var ?string
     */
    private $plainPasswordConfirmation;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifiedAt;


    /**
     * @ORM\Column(type="boolean")
     */
    private $isEnable;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $subscription;

    /**
     * @ORM\ManyToMany(targetEntity=MProcess::class, mappedBy="validators")
     * @ORM\JoinTable("mprocessvalidators_user")
     */
    private $mProcessValidators;

    /**
     * @ORM\ManyToMany(targetEntity=MProcess::class, mappedBy="contributors")
     * @ORM\JoinTable("mprocesscontributors_user")
     */
    private $mProcessContributors;

    /**
     * @ORM\OneToMany(targetEntity=Subscription::class, mappedBy="user", orphanRemoval=true)
     */
    private $subscriptions;

    /**
     * @ORM\ManyToMany(targetEntity=Process::class, mappedBy="validators")
     * @ORM\JoinTable("processvalidators_user")
     *
     */
    private $processValidators;

    /**
     * @ORM\ManyToMany(targetEntity=Process::class, mappedBy="contributors")
     * @ORM\JoinTable("processcontributors_user")
     *
     */
    private $processContributors;


    public function __construct()
    {
        $this->mProcessValidators = new ArrayCollection();
        $this->mProcessContributors = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->processValidators = new ArrayCollection();
        $this->processContributors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPasswordConfirmation(string $plainPasswordConfirmation): self
    {
        $this->plainPasswordConfirmation = $plainPasswordConfirmation;

        return $this;
    }

    public function getPlainPasswordConfirmation(): ?string
    {
        return $this->plainPasswordConfirmation;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
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

    public function getEmailValidated(): ?bool
    {
        return $this->emailValidated;
    }

    public function setEmailValidated(bool $emailValidated): self
    {
        $this->emailValidated = $emailValidated;

        return $this;
    }

    public function getEmailValidatedToken(): ?string
    {
        return $this->emailValidatedToken;
    }

    public function setEmailValidatedToken(?string $emailValidatedToken): self
    {
        $this->emailValidatedToken = $emailValidatedToken;

        return $this;
    }

    public function getLoginAt(): ?\DateTimeInterface
    {
        return $this->loginAt;
    }

    public function setLoginAt(?\DateTimeInterface $loginAt): self
    {
        $this->loginAt = $loginAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

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

    public function getForgetToken(): ?string
    {
        return $this->forget_token;
    }

    public function setForgetToken(?string $forget_token): self
    {
        $this->forget_token = $forget_token;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }


    public function getSubscription(): ?bool
    {
        return $this->subscription;
    }

    public function setSubscription(bool $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getAvatar(): string
    {
        return 'avatar/' .$this->getId() . '.png';
    }

    /**
     * @return Collection|MProcess[]
     */
    public function getMProcessValidators(): Collection
    {
        return $this->mProcessValidators;
    }

    public function addMProcessValidator(MProcess $mProcessValidator): self
    {
        if (!$this->mProcessValidators->contains($mProcessValidator)) {
            $this->mProcessValidators[] = $mProcessValidator;
            $mProcessValidator->addValidator($this);
        }

        return $this;
    }

    public function removeMProcessValidator(MProcess $mProcessValidator): self
    {
        if ($this->mProcessValidators->contains($mProcessValidator)) {
            $this->mProcessValidators->removeElement($mProcessValidator);
            $mProcessValidator->removeValidator($this);
        }

        return $this;
    }

    /**
     * @return Collection|MProcess[]
     */
    public function getMProcessContributors(): Collection
    {
        return $this->mProcessContributors;
    }

    public function addMProcessContributor(MProcess $mProcessContributor): self
    {
        if (!$this->mProcessContributors->contains($mProcessContributor)) {
            $this->mProcessContributors[] = $mProcessContributor;
            $mProcessContributor->addContributor($this);
        }

        return $this;
    }

    public function removeMProcessContributor(MProcess $mProcessContributor): self
    {
        if ($this->mProcessContributors->contains($mProcessContributor)) {
            $this->mProcessContributors->removeElement($mProcessContributor);
            $mProcessContributor->removeContributor($this);
        }

        return $this;
    }

    /**
     * @return Collection|Subscription[]
     */
    public function getMPSubscriptions(): Collection
    {
        return $this->mPSubscriptions;
    }

    public function addMPSubscription(Subscription $mPSubscription): self
    {
        if (!$this->mPSubscriptions->contains($mPSubscription)) {
            $this->mPSubscriptions[] = $mPSubscription;
            $mPSubscription->setUser($this);
        }

        return $this;
    }

    public function removeMPSubscription(Subscription $mPSubscription): self
    {
        if ($this->mPSubscriptions->contains($mPSubscription)) {
            $this->mPSubscriptions->removeElement($mPSubscription);
            // set the owning side to null (unless already changed)
            if ($mPSubscription->getUser() === $this) {
                $mPSubscription->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Process[]
     */
    public function getProcessValidators(): Collection
    {
        return $this->processValidators;
    }

    public function addProcessValidator(Process $processValidator): self
    {
        if (!$this->processValidators->contains($processValidator)) {
            $this->processValidators[] = $processValidator;
            $processValidator->addValidator($this);
        }

        return $this;
    }

    public function removeProcessValidator(Process $processValidator): self
    {
        if ($this->processValidators->contains($processValidator)) {
            $this->processValidators->removeElement($processValidator);
            $processValidator->removeValidator($this);
        }

        return $this;
    }

    /**
     * @return Collection|Process[]
     */
    public function getProcessContributors(): Collection
    {
        return $this->processContributors;
    }

    public function addProcessContributor(Process $processContributor): self
    {
        if (!$this->processContributors->contains($processContributor)) {
            $this->processContributors[] = $processContributor;
            $processContributor->addContributor($this);
        }

        return $this;
    }

    public function removeProcessContributor(Process $processContributor): self
    {
        if ($this->processContributors->contains($processContributor)) {
            $this->processContributors->removeElement($processContributor);
            $processContributor->removeContributor($this);
        }

        return $this;
    }




}
