<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Pays = null;

    #[ORM\Column(length: 255)]
    private ?string $PrenomAcheteur = null;

    #[ORM\Column(length: 255)]
    private ?string $NomAcheteur = null;

    #[ORM\Column]
    private ?int $CodePostal = null;

    #[ORM\Column(length: 255)]
    private ?string $Ville = null;

    #[ORM\Column]
    private ?int $NumeroTelephone = null;

    #[ORM\Column]
    private ?int $Volume = null;

    #[ORM\Column]
    private ?int $poids = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateLivraison = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\OneToMany(mappedBy: 'laCommande', targetEntity: Colis::class)]
    private Collection $lesColis;

    #[ORM\ManyToMany(targetEntity: Casier::class, inversedBy: 'lesCommandes')]
    private Collection $lesCasiers;

    #[ORM\ManyToOne(inversedBy: 'lesCommandes')]
    private ?CompteUtilisateur $leCompteUtilisateur = null;

    public function __construct()
    {
        $this->lesColis = new ArrayCollection();
        $this->lesCasiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPays(): ?string
    {
        return $this->Pays;
    }

    public function setPays(string $Pays): static
    {
        $this->Pays = $Pays;

        return $this;
    }

    public function getPrenomAcheteur(): ?string
    {
        return $this->PrenomAcheteur;
    }

    public function setPrenomAcheteur(string $PrenomAcheteur): static
    {
        $this->PrenomAcheteur = $PrenomAcheteur;

        return $this;
    }

    public function getNomAcheteur(): ?string
    {
        return $this->NomAcheteur;
    }

    public function setNomAcheteur(string $NomAcheteur): static
    {
        $this->NomAcheteur = $NomAcheteur;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->CodePostal;
    }

    public function setCodePostal(int $CodePostal): static
    {
        $this->CodePostal = $CodePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): static
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getNumeroTelephone(): ?int
    {
        return $this->NumeroTelephone;
    }

    public function setNumeroTelephone(int $NumeroTelephone): static
    {
        $this->NumeroTelephone = $NumeroTelephone;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->Volume;
    }

    public function setVolume(int $Volume): static
    {
        $this->Volume = $Volume;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->DateLivraison;
    }

    public function setDateLivraison(\DateTimeInterface $DateLivraison): static
    {
        $this->DateLivraison = $DateLivraison;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

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
            $lesColi->setLaCommande($this);
        }

        return $this;
    }

    public function removeLesColi(Colis $lesColi): static
    {
        if ($this->lesColis->removeElement($lesColi)) {
            // set the owning side to null (unless already changed)
            if ($lesColi->getLaCommande() === $this) {
                $lesColi->setLaCommande(null);
            }
        }

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
        }

        return $this;
    }

    public function removeLesCasier(Casier $lesCasier): static
    {
        $this->lesCasiers->removeElement($lesCasier);

        return $this;
    }

    public function getLeCompteUtilisateur(): ?CompteUtilisateur
    {
        return $this->leCompteUtilisateur;
    }

    public function setLeCompteUtilisateur(?CompteUtilisateur $leCompteUtilisateur): static
    {
        $this->leCompteUtilisateur = $leCompteUtilisateur;

        return $this;
    }
}
