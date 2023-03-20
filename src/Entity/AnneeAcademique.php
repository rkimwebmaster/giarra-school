<?php

namespace App\Entity;

use App\Repository\AnneeAcademiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AnneeAcademiqueRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[UniqueEntity(fields: ['debut'], message: 'Une année acdemique similaire existe dejà dans le système')]
class AnneeAcademique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $debut = 2022;

    #[ORM\Column]
    private ?int $fin = null;

    #[ORM\Column]
    private ?bool $isEnCours = null;

    #[ORM\Column]
    private ?bool $isPasse = null;

    #[ORM\OneToMany(mappedBy: 'annneeAcademique', targetEntity: PromotionConcrete::class)]
    private Collection $promotionConcretes;

    #[ORM\OneToMany(mappedBy: 'anneeAcademique', targetEntity: Reinscription::class)]
    private Collection $reinscriptions;

    #[ORM\OneToMany(mappedBy: 'anneeAcademique', targetEntity: Frais::class)]
    private Collection $frais;

    #[ORM\Column(nullable: true)]
    private ?float $grandTotalFrais = null;

    #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function misAJourEtCreation(){
        $this->fin=$this->debut +1;
        if($this->isEnCours){
            $this->isPasse=false;
        }
    }

    public function __toString()
    {
        return $this->debut ."-".$this->fin;
    }

    public function __construct()
    {
        $this->promotionConcretes = new ArrayCollection();
        $this->reinscriptions = new ArrayCollection();
        $this->isPasse=true;
        $this->frais = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebut(): ?int
    {
        return $this->debut;
    }

    public function setDebut(int $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?int
    {
        return $this->fin;
    }

    public function setFin(int $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    public function isIsEnCours(): ?bool
    {
        return $this->isEnCours;
    }

    public function setIsEnCours(bool $isEnCours): self
    {
        $this->isEnCours = $isEnCours;

        return $this;
    }

    public function isIsPasse(): ?bool
    {
        return $this->isPasse;
    }

    public function setIsPasse(bool $isPasse): self
    {
        $this->isPasse = $isPasse;

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
            $promotionConcrete->setAnnneeAcademique($this);
        }

        return $this;
    }

    public function removePromotionConcrete(PromotionConcrete $promotionConcrete): self
    {
        if ($this->promotionConcretes->removeElement($promotionConcrete)) {
            // set the owning side to null (unless already changed)
            if ($promotionConcrete->getAnnneeAcademique() === $this) {
                $promotionConcrete->setAnnneeAcademique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reinscription>
     */
    public function getReinscriptions(): Collection
    {
        return $this->reinscriptions;
    }

    public function addReinscription(Reinscription $reinscription): self
    {
        if (!$this->reinscriptions->contains($reinscription)) {
            $this->reinscriptions->add($reinscription);
            $reinscription->setAnneeAcademique($this);
        }

        return $this;
    }

    public function removeReinscription(Reinscription $reinscription): self
    {
        if ($this->reinscriptions->removeElement($reinscription)) {
            // set the owning side to null (unless already changed)
            if ($reinscription->getAnneeAcademique() === $this) {
                $reinscription->setAnneeAcademique(null);
            }
        }

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
            $frai->setAnneeAcademique($this);
        }

        return $this;
    }

    public function removeFrai(Frais $frai): self
    {
        if ($this->frais->removeElement($frai)) {
            // set the owning side to null (unless already changed)
            if ($frai->getAnneeAcademique() === $this) {
                $frai->setAnneeAcademique(null);
            }
        }

        return $this;
    }

    public function getGrandTotalFrais(): ?float
    {
        return $this->grandTotalFrais;
    }

    public function setGrandTotalFrais(?float $grandTotalFrais): self
    {
        $this->grandTotalFrais = $grandTotalFrais;

        return $this;
    }

   
}
