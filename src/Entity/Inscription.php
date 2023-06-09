<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PromotionConcrete $promotionConcrete = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observation = null;


    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: Reinscription::class)]
    private Collection $reinscriptions;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $matricule = null;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: EtudiantAnneeAcademique::class,cascade:["persist"])]
    private Collection $etudiantAnneeAcademiques;


    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?EtudiantAnneeAcademique $premierEtudiantAnneeAcademique = null;

    #[ORM\OneToOne(inversedBy: 'inscription', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Paiement $paiement = null;

    // #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    // #[ORM\JoinColumn(nullable: false)]
    // private ?EtudiantAnneeAcademique $premierEtudiantAnneeAcademique = null;

    
    #[ORM\PrePersist]
    public function creation(){
        $promotionConcrete=$this->promotionConcrete;
        $anneeAcademique=$promotionConcrete->getAnnneeAcademique();
        $promotionAbstraite=$promotionConcrete->getPromotionAbstraite();
        $departement=$promotionAbstraite->getDepartement();
        $faculte=$departement->getFaculteSection();

        $matricule= $anneeAcademique->getDebut().$faculte->getId().$departement->getId().$promotionConcrete->getId();
        $this->matricule=$matricule;
        $this->etudiantAnneeAcademiques[0]->setMatricule($matricule);

        // $this->getPaiement()->setInscription($this);
        

        // dd($this->getPaiement());

        // $this->paiement->setUtilisateur($this->getUtilisateur());

    }
    
    #[ORM\PostLoad]
    public function chargement(){
        // dd("testons");
        // $this->setMatricule($this->getMatricule().$this->getId());
        $this->premierEtudiantAnneeAcademique=$this->etudiantAnneeAcademiques[0];
    }


    public function __toString()
    {
        return $this->etudiantAnneeAcademiques[0];
    }

    public function __construct(PromotionConcrete $promotionConcrete)
    {
        $this->promotionConcrete=$promotionConcrete;
        $this->reinscriptions = new ArrayCollection();
        $this->date=new \DateTimeImmutable();
        $this->etudiantAnneeAcademiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

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
            $reinscription->setInscription($this);
        }

        return $this;
    }

    public function removeReinscription(Reinscription $reinscription): self
    {
        if ($this->reinscriptions->removeElement($reinscription)) {
            // set the owning side to null (unless already changed)
            if ($reinscription->getInscription() === $this) {
                $reinscription->setInscription(null);
            }
        }

        return $this;
    }

    
    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * @return Collection<int, EtudiantAnneeAcademique>
     */
    public function getEtudiantAnneeAcademiques(): Collection
    {
        return $this->etudiantAnneeAcademiques;
    }

    public function addEtudiantAnneeAcademique(EtudiantAnneeAcademique $etudiantAnneeAcademique): self
    {
        if (!$this->etudiantAnneeAcademiques->contains($etudiantAnneeAcademique)) {
            $this->etudiantAnneeAcademiques->add($etudiantAnneeAcademique);
            $etudiantAnneeAcademique->setInscription($this);
        }

        return $this;
    }

    public function removeEtudiantAnneeAcademique(EtudiantAnneeAcademique $etudiantAnneeAcademique): self
    {
        if ($this->etudiantAnneeAcademiques->removeElement($etudiantAnneeAcademique)) {
            // set the owning side to null (unless already changed)
            if ($etudiantAnneeAcademique->getInscription() === $this) {
                $etudiantAnneeAcademique->setInscription(null);
            }
        }

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

    public function getPremierEtudiantAnneeAcademique(): ?EtudiantAnneeAcademique
    {
        return $this->premierEtudiantAnneeAcademique;
    }

    public function setPremierEtudiantAnneeAcademique(?EtudiantAnneeAcademique $premierEtudiantAnneeAcademique): self
    {
        $this->premierEtudiantAnneeAcademique = $premierEtudiantAnneeAcademique;

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
