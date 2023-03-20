<?php

namespace App\Entity;

use App\Repository\PromotionAbstraiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PromotionAbstraiteRepository::class)]
#[UniqueEntity(fields: ['designation', 'departement'], message: 'Cette promotion existe déjà')]
class PromotionAbstraite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'promotionAbstraites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Departement $departement = null;

    #[ORM\OneToMany(mappedBy: 'promotionAbstraite', targetEntity: PromotionConcrete::class)]
    private Collection $promotionConcretes;

    public function __toString()
    {
        return $this->designation."/".$this->departement;
    }

    public function __construct()
    {
        $this->promotionConcretes = new ArrayCollection();
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

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

   
    /**
     * @return Collection<int, PromotionConcrete>
     */
    public function getPromotionConcretes(): Collection
    {
        return $this->promotionConcretes;
    }

    public function addPromotionConcrete(PromotionConcrete $promotionConcrete): self
    {
        if (!$this->promotionConcretes->contains($promotionConcrete)) {
            $this->promotionConcretes->add($promotionConcrete);
            $promotionConcrete->setPromotionAbstraite($this);
        }

        return $this;
    }

    public function removePromotionConcrete(PromotionConcrete $promotionConcrete): self
    {
        if ($this->promotionConcretes->removeElement($promotionConcrete)) {
            // set the owning side to null (unless already changed)
            if ($promotionConcrete->getPromotionAbstraite() === $this) {
                $promotionConcrete->setPromotionAbstraite(null);
            }
        }

        return $this;
    }
}
