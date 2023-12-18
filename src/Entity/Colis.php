<?php

namespace App\Entity;

use App\Repository\ColisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;

#[ORM\Entity(repositoryClass: ColisRepository::class)]
#[ApiResource(
    operations:[
        new Get(),
    ]
)]
class Colis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Volume = null;

    #[ORM\Column]
    private ?int $Poids = null;

    #[ORM\ManyToOne(inversedBy: 'lesColis')]
    private ?Commande $laCommande = null;

    #[ORM\ManyToOne(inversedBy: 'lesColis')]
    private ?Casier $casier = null;

    #[ORM\ManyToOne(inversedBy: 'lesColis')]
    private ?Etat $etat = null;

    public function getId(): ?int
    {
        return $this->id;
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
        return $this->Poids;
    }

    public function setPoids(int $Poids): static
    {
        $this->Poids = $Poids;

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

    public function getCasier(): ?Casier
    {
        return $this->casier;
    }

    public function setCasier(?Casier $casier): static
    {
        $this->casier = $casier;
    
        return $this;
    }    

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): static
    {
        $this->etat = $etat;

        return $this;
    }
}
