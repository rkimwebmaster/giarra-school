<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Frais $frais = null;

    // #[ORM\ManyToOne(inversedBy: 'paiements')]
    // #[ORM\JoinColumn(nullable: false)]
    // private ?InscriptionReinscription $inscriptionReinscription = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePaiement = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    private ?Inscription $inscription = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    private ?Reinscription $reinscription = null;

    
    // #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function misAJourEtCreation(){
        $this->getFrais()->setTotalPerception($this->getFrais()->getTotalPerception() + $this->getFrais()->getMontant());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFrais(): ?Frais
    {
        return $this->frais;
    }

    public function setFrais(?Frais $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(\DateTimeInterface $datePaiement): self
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getReinscription(): ?Reinscription
    {
        return $this->reinscription;
    }

    public function setReinscription(?Reinscription $reinscription): self
    {
        $this->reinscription = $reinscription;

        return $this;
    }
}