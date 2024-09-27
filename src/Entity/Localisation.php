<?php

namespace App\Entity;

use App\Repository\LocalisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalisationRepository::class)]
class Localisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'localisation', targetEntity: Commande::class)]
    private Collection $lesCommandes;

    #[ORM\OneToMany(mappedBy: 'laLocalisation', targetEntity: LocalisationColis::class)]
    private Collection $localisationColis;

    public function __construct()
    {
        $this->lesCommandes = new ArrayCollection();
        $this->localisationColis = new ArrayCollection();
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

    /**
     * @return Collection<int, Commande>
     */
    public function getLesCommandes(): Collection
    {
        return $this->lesCommandes;
    }

    public function addLesCommande(Commande $lesCommande): static
    {
        if (!$this->lesCommandes->contains($lesCommande)) {
            $this->lesCommandes->add($lesCommande);
            $lesCommande->setLocalisation($this);
        }

        return $this;
    }

    public function removeLesCommande(Commande $lesCommande): static
    {
        if ($this->lesCommandes->removeElement($lesCommande)) {
            // set the owning side to null (unless already changed)
            if ($lesCommande->getLocalisation() === $this) {
                $lesCommande->setLocalisation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LocalisationColis>
     */
    public function getLocalisationColis(): Collection
    {
        return $this->localisationColis;
    }

    public function addLocalisationColi(LocalisationColis $localisationColi): static
    {
        if (!$this->localisationColis->contains($localisationColi)) {
            $this->localisationColis->add($localisationColi);
            $localisationColi->setLaLocalisation($this);
        }

        return $this;
    }

    public function removeLocalisationColi(LocalisationColis $localisationColi): static
    {
        if ($this->localisationColis->removeElement($localisationColi)) {
            // set the owning side to null (unless already changed)
            if ($localisationColi->getLaLocalisation() === $this) {
                $localisationColi->setLaLocalisation(null);
            }
        }

        return $this;
    }
}
