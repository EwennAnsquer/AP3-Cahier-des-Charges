<?php

namespace App\Entity;

use App\Repository\CentreRelaisColisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;

#[ORM\Entity(repositoryClass: CentreRelaisColisRepository::class)]
#[ApiResource(
    operations:[
        new Get(),
    ]
)]
class CentreRelaisColis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\OneToMany(mappedBy: 'leCentreRelaisColis', targetEntity: Casier::class)]
    private Collection $lesCasiers;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\OneToMany(mappedBy: 'leCentreRelaisColisDefaut', targetEntity: CompteUtilisateur::class, orphanRemoval: false)]
    private Collection $compteUtilisateurs;

    #[ORM\ManyToOne(inversedBy: 'lesCentresRelaisColis')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Ville $ville = null;

    public function __construct()
    {
        $this->lesCasiers = new ArrayCollection();
        $this->compteUtilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Casier>
     */
    public function getLesCasiers(): Collection
    {
        return $this->lesCasiers;
    }

    public function addLesCasier(Casier $lesCasier): static
    {
        if (!$this->lesCasiers->contains($lesCasier)) {
            $this->lesCasiers->add($lesCasier);
            $lesCasier->setLeCentreRelaisColis($this);
        }

        return $this;
    }

    public function removeLesCasier(Casier $lesCasier): static
    {
        if ($this->lesCasiers->removeElement($lesCasier)) {
            // set the owning side to null (unless already changed)
            if ($lesCasier->getLeCentreRelaisColis() === $this) {
                $lesCasier->setLeCentreRelaisColis(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return Collection<int, CompteUtilisateur>
     */
    public function getCompteUtilisateurs(): Collection
    {
        return $this->compteUtilisateurs;
    }

    public function addCompteUtilisateur(CompteUtilisateur $compteUtilisateur): static
    {
        if (!$this->compteUtilisateurs->contains($compteUtilisateur)) {
            $this->compteUtilisateurs->add($compteUtilisateur);
            $compteUtilisateur->setLeCentreRelaisColisDefaut($this);
        }

        return $this;
    }

    public function removeCompteUtilisateur(CompteUtilisateur $compteUtilisateur): static
    {
        if ($this->compteUtilisateurs->removeElement($compteUtilisateur)) {
            // set the owning side to null (unless already changed)
            if ($compteUtilisateur->getLeCentreRelaisColisDefaut() === $this) {
                $compteUtilisateur->setLeCentreRelaisColisDefaut(null);
            }
        }

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): static
    {
        $this->ville = $ville;

        return $this;
    }
}
