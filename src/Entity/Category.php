<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * */
class Category implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
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
     * @ORM\Column(type="boolean")
     */
    private $isValidateByControl;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isValidateByDoc;

    /**
     * @ORM\Column(type="smallint")
     */
    private $timeBeforeRevision;

    /**
     * @ORM\OneToMany(targetEntity=Backpack::class, mappedBy="category")
     */
    private $backpacks;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $icone;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $bgcolor;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $forecolor;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $workflow_name;

    public function __construct()
     {
         $this->isEnable=true;
         $this->isValidateByControl=false;
         $this->isValidateByDoc=true;
         $this->timeBeforeRevision=12;
         $this->backpacks = new ArrayCollection();
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

    public function getIsValidateByControl(): bool
    {
        return $this->isValidateByControl;
    }

    public function setIsValidateByControl(bool $isValidateByControl): self
    {
        $this->isValidateByControl = $isValidateByControl;

        return $this;
    }

    public function getIsValidateByDoc(): bool
    {
        return $this->isValidateByDoc; 
    }

    public function setIsValidateByDoc(bool $isValidateByDoc): self
    {
        $this->isValidateByDoc = $isValidateByDoc;

        return $this;
    }

    public function getTimeBeforeRevision(): ?int
    {
        return $this->timeBeforeRevision;
    }

    public function setTimeBeforeRevision(int $timeBeforeRevision): self
    {
        $this->timeBeforeRevision = $timeBeforeRevision;

        return $this;
    }

    /**
     * @return Collection|Backpack[]
     */
    public function getBackpacks(): Collection
    {
        return $this->backpacks;
    }

    public function addBackpack(Backpack $backpack): self
    {
        if (!$this->backpacks->contains($backpack)) {
            $this->backpacks[] = $backpack;
            $backpack->setCategory($this);
        }

        return $this;
    }

    public function removeBackpack(Backpack $backpack): self
    {
        if ($this->backpacks->contains($backpack)) {
            $this->backpacks->removeElement($backpack);
            // set the owning side to null (unless already changed)
            if ($backpack->getCategory() === $this) {
                $backpack->setCategory(null);
            }
        }

        return $this;
    }

    public function getIcone(): ?string
    {
        return $this->icone;
    }

    public function setIcone(?string $icone): self
    {
        $this->icone = $icone;

        return $this;
    }

    public function getBgcolor(): ?string
    {
        return $this->bgcolor;
    }

    public function setBgcolor(?string $bgcolor): self
    {
        $this->bgcolor = $bgcolor;

        return $this;
    }

    public function getForecolor(): ?string
    {
        return $this->forecolor;
    }

    public function setForecolor(?string $forecolor): self
    {
        $this->forecolor = $forecolor;

        return $this;
    }

    public function getWorkflowName(): ?string
    {
        return $this->workflow_name;
    }

    public function setWorkflowName(string $workflow_name): self
    {
        $this->workflow_name = $workflow_name;

        return $this;
    }
}
