<?php

namespace App\Entity;

use App\Repository\CasierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;

#[ORM\Entity(repositoryClass: CasierRepository::class)]
#[ApiResource(
    operations:[
        new Get(),
    ]
)]
class Casier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $volume = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateDebutReservation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateFinReservation = null;

    #[ORM\ManyToOne(inversedBy: 'lesCasiers')]
    private ?CentreRelaisColis $leCentreRelaisColis = null;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'lesCasiers')]
    private Collection $lesCommandes;

    public function __construct()
    {
        $this->lesCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(int $volume): static
    {
        $this->volume = $volume;

        return $this;
    }

    public function getDateDebutReservation(): ?\DateTimeInterface
    {
        return $this->DateDebutReservation;
    }

    public function setDateDebutReservation(\DateTimeInterface $DateDebutReservation): static
    {
        $this->DateDebutReservation = $DateDebutReservation;

        return $this;
    }

    public function getDateFinReservation(): ?\DateTimeInterface
    {
        return $this->DateFinReservation;
    }

    public function setDateFinReservation(\DateTimeInterface $DateFinReservation): static
    {
        $this->DateFinReservation = $DateFinReservation;

        return $this;
    }

    public function getLeCentreRelaisColis(): ?CentreRelaisColis
    {
        return $this->leCentreRelaisColis;
    }

    public function setLeCentreRelaisColis(?CentreRelaisColis $leCentreRelaisColis): static
    {
        $this->leCentreRelaisColis = $leCentreRelaisColis;

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
            $lesCommande->addLesCasier($this);
        }

        return $this;
    }

    public function removeLesCommande(Commande $lesCommande): static
    {
        if ($this->lesCommandes->removeElement($lesCommande)) {
            $lesCommande->removeLesCasier($this);
        }

        return $this;
    }
}
