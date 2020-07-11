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
     * @ORM\ManyToMany(targetEntity=MProcessus::class, mappedBy="validators")
     * @ORM\JoinTable("mprocessusvalidators_user")
     */
    private $MProcessusValidators;

    /**
     * @ORM\ManyToMany(targetEntity=MProcessus::class, mappedBy="contributors")
     * @ORM\JoinTable("mprocessuscontributors_user")
     */
    private $MProcessusContributors;

    /**
     * @ORM\OneToMany(targetEntity=MPSubscription::class, mappedBy="user", orphanRemoval=true)
     */
    private $mPSubscriptions;


    public function __construct()
    {
        $this->MProcessusValidators = new ArrayCollection();
        $this->MProcessusContributors = new ArrayCollection();
        $this->mPSubscriptions = new ArrayCollection();
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
     * @return Collection|MProcessus[]
     */
    public function getMProcessusValidators(): Collection
    {
        return $this->MProcessusValidators;
    }

    public function addMProcessusValidator(MProcessus $mProcessusValidator): self
    {
        if (!$this->MProcessusValidators->contains($mProcessusValidator)) {
            $this->MProcessusValidators[] = $mProcessusValidator;
            $mProcessusValidator->addValidator($this);
        }

        return $this;
    }

    public function removeMProcessusValidator(MProcessus $mProcessusValidator): self
    {
        if ($this->MProcessusValidators->contains($mProcessusValidator)) {
            $this->MProcessusValidators->removeElement($mProcessusValidator);
            $mProcessusValidator->removeValidator($this);
        }

        return $this;
    }

    /**
     * @return Collection|MProcessus[]
     */
    public function getMProcessusContributors(): Collection
    {
        return $this->MProcessusContributors;
    }

    public function addMProcessusContributor(MProcessus $mProcessusContributor): self
    {
        if (!$this->MProcessusContributors->contains($mProcessusContributor)) {
            $this->MProcessusContributors[] = $mProcessusContributor;
            $mProcessusContributor->addContributor($this);
        }

        return $this;
    }

    public function removeMProcessusContributor(MProcessus $mProcessusContributor): self
    {
        if ($this->MProcessusContributors->contains($mProcessusContributor)) {
            $this->MProcessusContributors->removeElement($mProcessusContributor);
            $mProcessusContributor->removeContributor($this);
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
            $mPSubscription->setUser($this);
        }

        return $this;
    }

    public function removeMPSubscription(MPSubscription $mPSubscription): self
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




}
