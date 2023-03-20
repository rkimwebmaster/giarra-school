<?php

namespace App\Entity;

use App\Repository\PromotionConcreteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PromotionConcreteRepository::class)]
#[UniqueEntity(fields: ['promotionAbstraite', 'annneeAcademique', 'specification'], message: 'Cette promotion avec la même spécification existe déjà pour la même année academique')]
class PromotionConcrete
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'promotionConcretes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PromotionAbstraite $promotionAbstraite = null;

    #[ORM\ManyToOne(inversedBy: 'promotionConcretes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnneeAcademique $annneeAcademique = null;

    // #[ORM\OneToMany(mappedBy: 'promotionConcrete', targetEntity: InscriptionReinscription::class)]
    // private Collection $inscriptionReinscriptions;

    #[ORM\OneToMany(mappedBy: 'promotionConcrete', targetEntity: Inscription::class)]
    private Collection $inscriptions;

    #[ORM\OneToMany(mappedBy: 'promotionConcrete', targetEntity: Reinscription::class)]
    private Collection $reinscriptions;

    #[ORM\OneToMany(mappedBy: 'promotionActuelle', targetEntity: EtudiantAnneeAcademique::class)]
    private Collection $etudiantAnneeAcademiques;

    #[ORM\Column(length: 1)]
    private ?string $specification = null;

    // #[ORM\OneToMany(mappedBy: 'promotionConcreteCourante', targetEntity: Etudiant::class)]
    // private Collection $etudiants;

    public function __toString()
    {
        return $this->promotionAbstraite." ".$this->specification." (".$this->annneeAcademique . ")";
    }

    ///pour echapper a l erreur d orthographe de la methode get anne ancademique 
    public function getAnneeAcademique(){
        return $this->annneeAcademique;
    }

    public function __construct()
    {
        // $this->inscriptionReinscriptions = new ArrayCollection();
        // $this->etudiants = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->reinscriptions = new ArrayCollection();
        $this->etudiantAnneeAcademiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPromotionAbstraite(): ?PromotionAbstraite
    {
        return $this->promotionAbstraite;
    }

    public function setPromotionAbstraite(?PromotionAbstraite $promotionAbstraite): self
    {
        $this->promotionAbstraite = $promotionAbstraite;

        return $this;
    }

    public function getAnnneeAcademique(): ?AnneeAcademique
    {
        return $this->annneeAcademique;
    }

    public function setAnnneeAcademique(?AnneeAcademique $annneeAcademique): self
    {
        $this->annneeAcademique = $annneeAcademique;

        return $this;
    }

   
    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setPromotionConcrete($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getPromotionConcrete() === $this) {
                $inscription->setPromotionConcrete(null);
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
            $reinscription->setPromotionConcrete($this);
        }

        return $this;
    }

    public function removeReinscription(Reinscription $reinscription): self
    {
        if ($this->reinscriptions->removeElement($reinscription)) {
            // set the owning side to null (unless already changed)
            if ($reinscription->getPromotionConcrete() === $this) {
                $reinscription->setPromotionConcrete(null);
            }
        }

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
            $etudiantAnneeAcademique->setPromotionActuelle($this);
        }

        return $this;
    }

    public function removeEtudiantAnneeAcademique(EtudiantAnneeAcademique $etudiantAnneeAcademique): self
    {
        if ($this->etudiantAnneeAcademiques->removeElement($etudiantAnneeAcademique)) {
            // set the owning side to null (unless already changed)
            if ($etudiantAnneeAcademique->getPromotionActuelle() === $this) {
                $etudiantAnneeAcademique->setPromotionActuelle(null);
            }
        }

        return $this;
    }

    public function getSpecification(): ?string
    {
        return $this->specification;
    }

    public function setSpecification(string $specification): self
    {
        $this->specification = $specification;

        return $this;
    }
}
