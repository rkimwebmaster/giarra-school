<?php

namespace App\Entity;

use App\Repository\EtudiantAnneeAcademiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantAnneeAcademiqueRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class EtudiantAnneeAcademique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $matricule = null;

    #[ORM\Column(length: 255)]
    private ?string $telephoneTuteur = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Identite $identite = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Adresse $adresse = null;

    #[ORM\Column]
    private ?bool $hasReussie = null;

    #[ORM\OneToMany(mappedBy: 'etudiantAnneeAcademique', targetEntity: Reinscription::class)]
    private Collection $reinscriptions;

    #[ORM\ManyToOne(inversedBy: 'etudiantAnneeAcademiques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PromotionConcrete $promotionActuelle = null;

    //from reinscription ou initialisé de la premiere inscription 
    #[ORM\ManyToOne(inversedBy: 'etudiantAnneeAcademiques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Inscription $inscription = null;
   
    #[ORM\PostLoad]
    public function creation(){
        $this->setMatricule($this->getInscription()->getMatricule().$this->getInscription()->getId());
    }

    public function __toString()
    {
        return $this->identite;
    }

    public function __construct()
    {
        $this->reinscriptions = new ArrayCollection();
        $this->hasReussie=false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getTelephoneTuteur(): ?string
    {
        return $this->telephoneTuteur;
    }

    public function setTelephoneTuteur(string $telephoneTuteur): self
    {
        $this->telephoneTuteur = $telephoneTuteur;

        return $this;
    }

    public function getIdentite(): ?Identite
    {
        return $this->identite;
    }

    public function setIdentite(Identite $identite): self
    {
        $this->identite = $identite;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function isHasReussie(): ?bool
    {
        return $this->hasReussie;
    }

    public function setHasReussie(bool $hasReussie): self
    {
        $this->hasReussie = $hasReussie;

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
            $reinscription->setEtudiantAnneeAcademique($this);
        }

        return $this;
    }

    public function removeReinscription(Reinscription $reinscription): self
    {
        if ($this->reinscriptions->removeElement($reinscription)) {
            // set the owning side to null (unless already changed)
            if ($reinscription->getEtudiantAnneeAcademique() === $this) {
                $reinscription->setEtudiantAnneeAcademique(null);
            }
        }

        return $this;
    }

    public function getPromotionActuelle(): ?PromotionConcrete
    {
        return $this->promotionActuelle;
    }

    public function setPromotionActuelle(?PromotionConcrete $promotionActuelle): self
    {
        $this->promotionActuelle = $promotionActuelle;

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

}
