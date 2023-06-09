<?php

namespace App\Entity;

use App\Repository\FraisAbstraitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: FraisAbstraitRepository::class)]
#[UniqueEntity(fields: ['designation'], message: 'Ce frais existe dejà dans le système')]
class FraisAbstrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $designation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'fraisAbstrait', targetEntity: Frais::class)]
    private Collection $frais;

    #[ORM\Column]
    private ?bool $isInscription = null;

    #[ORM\Column]
    private ?bool $isReinscription = null;

    public function __toString()
    {
        return $this->designation;
    }

    public function __construct()
    {
        $this->frais = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Frais>
     */
    public function getFrais(): Collection
    {
        return $this->frais;
    }

    public function addFrai(Frais $frai): self
    {
        if (!$this->frais->contains($frai)) {
            $this->frais->add($frai);
            $frai->setFraisAbstrait($this);
        }

        return $this;
    }

    public function removeFrai(Frais $frai): self
    {
        if ($this->frais->removeElement($frai)) {
            // set the owning side to null (unless already changed)
            if ($frai->getFraisAbstrait() === $this) {
                $frai->setFraisAbstrait(null);
            }
        }

        return $this;
    }

    public function isIsInscription(): ?bool
    {
        return $this->isInscription;
    }

    public function setIsInscription(bool $isInscription): self
    {
        $this->isInscription = $isInscription;

        return $this;
    }

    public function isIsReinscription(): ?bool
    {
        return $this->isReinscription;
    }

    public function setIsReinscription(bool $isReinscription): self
    {
        $this->isReinscription = $isReinscription;

        return $this;
    }
}
