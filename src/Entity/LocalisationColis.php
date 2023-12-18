<?php

namespace App\Entity;

use App\Repository\LocalisationColisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalisationColisRepository::class)]
class LocalisationColis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'localisationColis')]
    private ?Localisation $laLocalisation = null;

    #[ORM\ManyToOne(inversedBy: 'localisationColis')]
    private ?Commande $laCommande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getLaLocalisation(): ?Localisation
    {
        return $this->laLocalisation;
    }

    public function setLaLocalisation(?Localisation $laLocalisation): static
    {
        $this->laLocalisation = $laLocalisation;

        return $this;
    }

    public function getLaCommande(): ?Commande
    {
        return $this->laCommande;
    }

    public function setLaCommande(?Commande $laCommande): static
    {
        $this->laCommande = $laCommande;

        return $this;
    }
}
