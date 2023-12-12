<?php

namespace App\Entity;

use App\Repository\CompteUtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;

#[ORM\Entity(repositoryClass: CompteUtilisateurRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class CompteUtilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'leCompteUtilisateur', targetEntity: Commande::class)]
    private Collection $lesCommandes;

    public function __construct()
    {
        $this->lesCommandes = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $verificationToken;

    #[ORM\Column]
    private ?bool $isRegister = null;

    #[ORM\Column]
    private ?int $registerNumber = null;

    #[ORM\ManyToOne(inversedBy: 'compteUtilisateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeNotification $leTypeNotification = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $registerDate = null;

    #[ORM\ManyToOne(inversedBy: 'compteUtilisateurs')]
    #[ORM\JoinColumn(nullable: true)]
    private ?CentreRelaisColis $leCentreRelaisColisDefaut = null;

    #[ORM\OneToMany(mappedBy: 'leCompteUtilisateur', targetEntity: Notification::class)]
    private Collection $notifications;

    public function getVerificationToken(): ?string
    {
        return $this->verificationToken;
    }

    public function setVerificationToken(?string $verificationToken): self
    {
        $this->verificationToken = $verificationToken;

        return $this;
    }

    public function isIsRegister(): ?bool
    {
        return $this->isRegister;
    }

    public function setIsRegister(bool $isRegister): static
    {
        $this->isRegister = $isRegister;

        return $this;
    }

    public function getRegisterNumber(): ?int
    {
        return $this->registerNumber;
    }

    public function setRegisterNumber(int $registerNumber): static
    {
        $this->registerNumber = $registerNumber;

        return $this;
    }

    public static function findByEmail(string $email, EntityManagerInterface $entityManagerInterface): ?self
    {
        return $entityManagerInterface
            ->getRepository(self::class)
            ->findOneBy(['email' => $email]);
    }

    public function isRegisterNumberCorrectForEmail(string $email, int $registerNumber): bool
    {
        return $this->getEmail() === $email && $this->getRegisterNumber() === $registerNumber;
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

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->registerDate;
    }

    public function setRegisterDate(\DateTimeInterface $registerDate): static
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    public function getLeCentreRelaisColisDefaut(): ?CentreRelaisColis
    {
        return $this->leCentreRelaisColisDefaut;
    }

    public function setLeCentreRelaisColisDefaut(?CentreRelaisColis $leCentreRelaisColisDefaut): static
    {
        $this->leCentreRelaisColisDefaut = $leCentreRelaisColisDefaut;

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
            $notification->setLeCompteUtilisateur($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getLeCompteUtilisateur() === $this) {
                $notification->setLeCompteUtilisateur(null);
            }
        }

        return $this;
    }
}
