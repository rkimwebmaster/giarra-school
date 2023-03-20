<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
#[UniqueEntity(fields: ['designation','faculteSection'], message: 'Cette option est déjà créée dans la faculté choisie')]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'departements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FaculteSection $faculteSection = null;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: PromotionAbstraite::class)]
    private Collection $promotionAbstraites;

    public function __toString()
    {
        return strtoupper($this->designation."-".$this->faculteSection) ;
    }

    public function __construct()
    {
        $this->promotionAbstraites = new ArrayCollection();
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

    public function getFaculteSection(): ?FaculteSection
    {
        return $this->faculteSection;
    }

    public function setFaculteSection(?FaculteSection $faculteSection): self
    {
        $this->faculteSection = $faculteSection;

        return $this;
    }

    /**
     * @return Collection<int, PromotionAbstraite>
     */
    public function getPromotionAbstraites(): Collection
    {
        return $this->promotionAbstraites;
    }

    public function addPromotionAbstraite(PromotionAbstraite $promotionAbstraite): self
    {
        if (!$this->promotionAbstraites->contains($promotionAbstraite)) {
            $this->promotionAbstraites->add($promotionAbstraite);
            $promotionAbstraite->setDepartement($this);
        }

        return $this;
    }

    public function removePromotionAbstraite(PromotionAbstraite $promotionAbstraite): self
    {
        if ($this->promotionAbstraites->removeElement($promotionAbstraite)) {
            // set the owning side to null (unless already changed)
            if ($promotionAbstraite->getDepartement() === $this) {
                $promotionAbstraite->setDepartement(null);
            }
        }

        return $this;
    }
}
