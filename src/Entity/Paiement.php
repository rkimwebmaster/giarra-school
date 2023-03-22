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

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePaiement = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\OneToOne(mappedBy: 'paiement', cascade: ['persist', 'remove'])]
    private ?Inscription $inscription = null;

    #[ORM\ManyToOne(inversedBy: 'paiements',cascade:["persist"])]
    private ?EtudiantAnneeAcademique $etudiantAnneeAcademique = null;

    public function __toString()
    {
        return "jambo";
    }

    
    // #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function misAJourEtCreation(){
        $this->getFrais()->setTotalPerception($this->getFrais()->getTotalPerception() + $this->getFrais()->getMontant());
        $this->datePaiement=new \DateTimeImmutable();

    }

    public function __construct()
    {
        $this->datePaiement=new \DateTimeImmutable();
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

    public function setInscription(Inscription $inscription): self
    {
        // set the owning side of the relation if necessary
        if ($inscription->getPaiement() !== $this) {
            $inscription->setPaiement($this);
        }

        $this->inscription = $inscription;

        return $this;
    }

    public function getEtudiantAnneeAcademique(): ?EtudiantAnneeAcademique
    {
        return $this->etudiantAnneeAcademique;
    }

    public function setEtudiantAnneeAcademique(?EtudiantAnneeAcademique $etudiantAnneeAcademique): self
    {
        $this->etudiantAnneeAcademique = $etudiantAnneeAcademique;

        return $this;
    }

}
