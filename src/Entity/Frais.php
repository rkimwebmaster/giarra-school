<?php

namespace App\Entity;

use App\Repository\FraisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: FraisRepository::class)]
#[UniqueEntity(fields: ['fraisAbstrait','anneeAcademique'], message: 'Ce frais existe dejà pour cette année academique dans le système')]
class Frais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateButoire = null;

    #[ORM\OneToMany(mappedBy: 'frais', targetEntity: Paiement::class)]
    private Collection $paiements;

    #[ORM\ManyToOne(inversedBy: 'frais')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FraisAbstrait $fraisAbstrait = null;

    #[ORM\ManyToOne(inversedBy: 'frais')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnneeAcademique $anneeAcademique = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(nullable: true)]
    private ?float $totalPerception = null;

    
    public function __toString()
    {
        return $this->fraisAbstrait." (". $this->anneeAcademique .")";
    }

    public function __construct()
    {
        $this->paiements = new ArrayCollection();
        $this->dateButoire=new \DateTimeImmutable('+ 10 days');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateButoire(): ?\DateTimeInterface
    {
        return $this->dateButoire;
    }

    public function setDateButoire(\DateTimeInterface $dateButoire): self
    {
        $this->dateButoire = $dateButoire;

        return $this;
    }

    /**
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): self
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setFrais($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getFrais() === $this) {
                $paiement->setFrais(null);
            }
        }

        return $this;
    }

    public function getFraisAbstrait(): ?FraisAbstrait
    {
        return $this->fraisAbstrait;
    }

    public function setFraisAbstrait(?FraisAbstrait $fraisAbstrait): self
    {
        $this->fraisAbstrait = $fraisAbstrait;

        return $this;
    }

    public function getAnneeAcademique(): ?AnneeAcademique
    {
        return $this->anneeAcademique;
    }

    public function setAnneeAcademique(?AnneeAcademique $anneeAcademique): self
    {
        $this->anneeAcademique = $anneeAcademique;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getTotalPerception(): ?float
    {
        return $this->totalPerception;
    }

    public function setTotalPerception(?float $totalPerception): self
    {
        $this->totalPerception = $totalPerception;

        return $this;
    }
}
