<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatRepository::class)]
class Etat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /*
    en préparation
    Prêt à expédier
    Expédié
    En transit
    En cours de livraison
    Livré
    En attente de ramassage
    */

    #[ORM\OneToMany(mappedBy: 'etat', targetEntity: Colis::class)]
    private Collection $lesColis;

    #[ORM\OneToMany(mappedBy: 'etat', targetEntity: Commande::class)]
    private Collection $commandes;

    public function __construct()
    {
        $this->lesColis = new ArrayCollection();
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

    /**
     * @return Collection<int, Colis>
     */
    public function getLesColis(): Collection
    {
        return $this->lesColis;
    }

    public function addLesColi(Colis $lesColi): static
    {
        if (!$this->lesColis->contains($lesColi)) {
            $this->lesColis->add($lesColi);
            $lesColi->setEtat($this);
        }

        return $this;
    }

    public function removeLesColi(Colis $lesColi): static
    {
        if ($this->lesColis->removeElement($lesColi)) {
            // set the owning side to null (unless already changed)
            if ($lesColi->getEtat() === $this) {
                $lesColi->setEtat(null);
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
            $commande->setEtat($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getEtat() === $this) {
                $commande->setEtat(null);
            }
        }

        return $this;
    }
}
