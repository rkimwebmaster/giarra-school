<?php

namespace App\Entity;

use App\Repository\ReinscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ReinscriptionRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[UniqueEntity(fields: ['inscription','anneeAcademique'], message: 'Une reinscription existe déjà pour cette étudiant pour cette année academique')]
class Reinscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'reinscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PromotionConcrete $promotionConcrete = null;

    #[ORM\ManyToOne]
    private ?User $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'reinscriptions',cascade:["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?EtudiantAnneeAcademique $etudiantAnneeAcademique = null;

    #[ORM\ManyToOne(inversedBy: 'reinscriptions')]
    private ?Inscription $inscription = null;

    #[ORM\ManyToOne(inversedBy: 'reinscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnneeAcademique $anneeAcademique = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Paiement $paiement = null;


    #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function misAJour(){
        $etudiant=$this->inscription->getEtudiantAnneeAcademique();
        $this->getEtudiantAnneeAcademique()->setPromotionActuelle($this->getPromotionConcrete());
    }


    public function __construct(Inscription $inscription)
    {
        $this->inscription=$inscription;
        $etudiantAnneeAcademique= new EtudiantAnneeAcademique();

        $etudiantInscription=$inscription->getEtudiantAnneeAcademique();
        $etudiantAnneeAcademique->setHasReussie($etudiantInscription->isHasReussie());
        $etudiantAnneeAcademique->setIdentite($etudiantInscription->getIdentite());
        $etudiantAnneeAcademique->setMatricule($etudiantInscription->getMatricule());
        $etudiantAnneeAcademique->setTelephoneTuteur($etudiantInscription->getTelephoneTuteur());
        
        $this->setEtudiantAnneeAcademique($etudiantAnneeAcademique);        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPromotionConcrete(): ?PromotionConcrete
    {
        return $this->promotionConcrete;
    }

    public function setPromotionConcrete(?PromotionConcrete $promotionConcrete): self
    {
        $this->promotionConcrete = $promotionConcrete;

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

    public function getEtudiantAnneeAcademique(): ?EtudiantAnneeAcademique
    {
        return $this->etudiantAnneeAcademique;
    }

    public function setEtudiantAnneeAcademique(?EtudiantAnneeAcademique $etudiantAnneeAcademique): self
    {
        $this->etudiantAnneeAcademique = $etudiantAnneeAcademique;

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

    public function getAnneeAcademique(): ?AnneeAcademique
    {
        return $this->anneeAcademique;
    }

    public function setAnneeAcademique(?AnneeAcademique $anneeAcademique): self
    {
        $this->anneeAcademique = $anneeAcademique;

        return $this;
    }

    public function getPaiement(): ?Paiement
    {
        return $this->paiement;
    }

    public function setPaiement(Paiement $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }

    
}
