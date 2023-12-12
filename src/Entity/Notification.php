<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?CompteUtilisateur $leCompteUtilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?TypeNotification $leTypeNotification = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLeTypeNotification(): ?TypeNotification
    {
        return $this->leTypeNotification;
    }

    public function setLeTypeNotification(?TypeNotification $leTypeNotification): static
    {
        $this->leTypeNotification = $leTypeNotification;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
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
}
