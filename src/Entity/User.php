<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Die E-Mail Adresse wird bereits verwendet")
 */
class User implements UserInterface,PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var null|string The hashed password
     * @ORM\Column(type="string")
     */
    private ?string $password = null;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isVerified = false;

    /**
     * @ORM\OneToOne(targetEntity=ActivationCode::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $activationCode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->setRoles(['ROLE_USER']);
    }

    public function __toString(): string
    {
        return $this->getUsername();
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function setUsername(string $username): self
    {
        $this->email = $username;

        return $this;
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getActivationCode(): ?ActivationCode
    {
        return $this->activationCode;
    }

    public function setActivationCode(?ActivationCode $activationCode): self
    {
        // unset the owning side of the relation if necessary
        if ($activationCode === null && $this->activationCode !== null) {
            $this->activationCode->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($activationCode !== null && $activationCode->getUser() !== $this) {
            $activationCode->setUser($this);
        }

        $this->activationCode = $activationCode;

        return $this;
    }

    public function getUserIdentifier(): ?string
    {
        return $this->getEmail();
    }
}
