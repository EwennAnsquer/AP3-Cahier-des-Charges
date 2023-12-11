<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
#[ApiResource]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $codePostal = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: CentreRelaisColis::class)]
    private Collection $lesCentresRelaisColis;

    #[ORM\OneToMany(mappedBy: 'laVille', targetEntity: Commande::class)]
    private Collection $commandes;

    public function __construct()
    {
        $this->lesCentresRelaisColis = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, CentreRelaisColis>
     */
    public function getLesCentresRelaisColis(): Collection
    {
        return $this->lesCentresRelaisColis;
    }

    public function addLesCentresRelaisColi(CentreRelaisColis $lesCentresRelaisColi): static
    {
        if (!$this->lesCentresRelaisColis->contains($lesCentresRelaisColi)) {
            $this->lesCentresRelaisColis->add($lesCentresRelaisColi);
            $lesCentresRelaisColi->setVille($this);
        }

        return $this;
    }

    public function removeLesCentresRelaisColi(CentreRelaisColis $lesCentresRelaisColi): static
    {
        if ($this->lesCentresRelaisColis->removeElement($lesCentresRelaisColi)) {
            // set the owning side to null (unless already changed)
            if ($lesCentresRelaisColi->getVille() === $this) {
                $lesCentresRelaisColi->setVille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setLaVille($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLaVille() === $this) {
                $commande->setLaVille(null);
            }
        }

        return $this;
    }
}
