<?php

namespace App\Entity;

use App\Repository\CompteUtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteUtilisateurRepository::class)]
class CompteUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $AdresseMail = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\OneToMany(mappedBy: 'leCompteUtilisateur', targetEntity: Commande::class)]
    private Collection $lesCommandes;

    public function __construct()
    {
        $this->lesCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresseMail(): ?string
    {
        return $this->AdresseMail;
    }

    public function setAdresseMail(string $AdresseMail): static
    {
        $this->AdresseMail = $AdresseMail;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

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
            $lesCommande->setLeCompteUtilisateur($this);
        }

        return $this;
    }

    public function removeLesCommande(Commande $lesCommande): static
    {
        if ($this->lesCommandes->removeElement($lesCommande)) {
            // set the owning side to null (unless already changed)
            if ($lesCommande->getLeCompteUtilisateur() === $this) {
                $lesCommande->setLeCompteUtilisateur(null);
            }
        }

        return $this;
    }
}
