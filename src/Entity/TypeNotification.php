<?php

namespace App\Entity;

use App\Repository\TypeNotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeNotificationRepository::class)]
class TypeNotification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'leTypeNotification', targetEntity: CompteUtilisateur::class, orphanRemoval: true)]
    private Collection $compteUtilisateurs;

    #[ORM\OneToMany(mappedBy: 'leTypeNotification', targetEntity: Notification::class)]
    private Collection $notifications;

    public function __construct()
    {
        $this->compteUtilisateurs = new ArrayCollection();
        $this->notifications = new ArrayCollection();
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
            $compteUtilisateur->setLeTypeNotification($this);
        }

        return $this;
    }

    public function removeCompteUtilisateur(CompteUtilisateur $compteUtilisateur): static
    {
        if ($this->compteUtilisateurs->removeElement($compteUtilisateur)) {
            // set the owning side to null (unless already changed)
            if ($compteUtilisateur->getLeTypeNotification() === $this) {
                $compteUtilisateur->setLeTypeNotification(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setLeTypeNotification($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getLeTypeNotification() === $this) {
                $notification->setLeTypeNotification(null);
            }
        }

        return $this;
    }
}
